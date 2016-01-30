<?php
namespace Morenware\DutilsBundle\Command;

use AppKernel;
use Morenware\DutilsBundle\Entity\MediaCenterSettings;
use Morenware\DutilsBundle\Service\TorrentService;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation\Tag;
use Morenware\DutilsBundle\Util\GuidGenerator;
use Morenware\DutilsBundle\Service\ProcessManager;
use Symfony\Component\Process\Process;
use Morenware\DutilsBundle\Entity\TorrentState;
use Morenware\DutilsBundle\Service\CommandType;
use Monolog;

/**
 * @Service("renamecommand.service")
 * @Tag("console.command")
 *
 */
class RenameAndMoveCommand extends Command {

	private $logger;

	private $renamerLogger;

	/** @DI\Inject("processmanager.service")
     *  @var \Morenware\DutilsBundle\Service\ProcessManager $processManager
     */
	public $processManager;

	/** @DI\Inject("kernel")
     *  @var AppKernel $kernel
     */
	public $kernel;

	/** @DI\Inject("torrent.service")
     * @var \Morenware\DutilsBundle\Service\TorrentService $torrentService
     */
	public $torrentService;

	/** @DI\Inject("settings.service")
     * @var \Morenware\DutilsBundle\Service\SettingsService $settingsService
     */
	public $settingsService;

	// The script which actually performs a full rename of the downloads main folder
	const RENAME_SCRIPT_PATH = "scripts/multiple-rename-filebot.sh";

	// File whose presence indicates flags the process for termination
	const TERMINATED_FILE_NAME = "renamer.terminated";

	// File containing the PID of the renamer process. Its presence indicates that one and only
	// one is currently running
	const PID_FILE_NAME = "renamer.pid";

    const FILEBOT_SCRIPTS_PATH = "../components/filebot/scripts";

	/**
	 * @DI\InjectParams({
	 *     "logger" = @DI\Inject("logger"),
	 *     "renamerLogger" =  @DI\Inject("monolog.logger.renamer")
	 * })
	 */
	public function __construct(Logger $logger, Logger $renamerLogger) {

		$this->logger = $logger;
		$this->renamerLogger = $renamerLogger;
		parent::__construct();
	}


	protected function configure() {
		$this
		->setName('dutils:renamer')
		->setDescription('Rename files after download completion');
	}


	protected function execute(InputInterface $input, OutputInterface $output) {

		$logger = $this->logger;
		$pid = getmypid();
		$logger->info("[RENAMING] Starting Renamer process with PID $pid");
		$this->renamerLogger->info("[RENAMING] Starting Renamer process with PID $pid");
		$output->writeln("[RENAMING] Renamer process started with PID $pid");

        /** @var  \Morenware\DutilsBundle\Entity\MediaCenterSettings $mediacenterSettings */

		$mediacenterSettings = $this->settingsService->getDefaultMediacenterSettings();
		$processingTempPath = $mediacenterSettings->getProcessingTempPath();

		$this->renamerLogger->debug("[RENAMING] Read config from DB, processing temp path is $processingTempPath");

		$terminatedFile = $mediacenterSettings->getProcessingTempPath() . "/" . self::TERMINATED_FILE_NAME;
		$pidFile = $mediacenterSettings->getProcessingTempPath() . "/" . self::PID_FILE_NAME;

		// Check race condition, only one rename at a time
		if (file_exists($pidFile)) {
			$logger->info("[RENAMING] There is already one renamer process running -- exiting");
			return;
		}

		// Write pid file
		$handle = fopen($pidFile, "w");
		fwrite($handle, $pid);

		$terminated = false;

		if (file_exists($terminatedFile)) {
			$this->renamerLogger->debug("[RENAMING] Terminated renamer worker on demand");
			$terminated = true;
		}

		try {

			$polls = 0;
			$failedPolls = 0;
            $unsortedFolderAlreadyChecked = false;
            $isUnsortedFolder = false;

			while (!$terminated) {

				$this->renamerLogger->debug("[RENAMING] Checking if there are any torrents to rename...");
				$this->printMemoryUsage();
				$torrentsToRename = $this->torrentService->findTorrentsByState(TorrentState::DOWNLOAD_COMPLETED);

				if (count($torrentsToRename) > 0 || !$unsortedFolderAlreadyChecked) {

					$guid = GuidGenerator::generate();

                    if (count($torrentsToRename) == 0 && !$unsortedFolderAlreadyChecked) {
                        $this->renamerLogger->debug("[RENAMING] Checking [Unsorted] folder");
                        $isUnsortedFolder = true;
                    } else {
                        $this->renamerLogger->debug("[RENAMING] Detected torrents to rename in DOWNLOAD COMPLETED STATE");
                    }

					// Perform substitutions in the template renamer script
					list($scriptToExecute, $renamerLogFilePath) =
                        $this->prepareRenameScriptToExecute($torrentsToRename, $mediacenterSettings,
                                                            $pid . "_" . $guid,
															!$unsortedFolderAlreadyChecked,
                                                            $mediacenterSettings->getXbmcHostOrIp());

					$this->renamerLogger->debug("[RENAMING] The script to execute is $scriptToExecute");
					$renamerLogger = $this->renamerLogger;

					// Define callback function to monitor real time output of the process
					$waitCallback = function ($type, $buffer, Process $process) use ($renamerLogger, $terminatedFile) {

						$renamerLogger->debug("[RENAMING-EXECUTING-FILEBOT] ==> $buffer");

						if (file_exists($terminatedFile)) {
							$renamerLogger->debug("[RENAMING] Terminated renamer worker on demand");
							$process->stop();
						}
					};

					// By opening a new shell we avoid the execution permission
					$commandLineExec = "bash " . $scriptToExecute;

					// We provide a callback, so the process is not asynchronous in this particular case, it blocks until completed or timeout
					$process = $this->processManager->startProcessAsynchronouslyWithCallback($commandLineExec, $waitCallback);

					$exitCode = $process->getExitCode();
					$exitCodeText = $process->getExitCodeText();

					$renamerLogger->info("[RENAMING] Renamer process exitCode is $exitCodeText ==> $exitCode");

                    // If the Unsorted folder is being checked, it is likely it is empty and Filebot would fail -- check this here
					if ($isUnsortedFolder) {

                        $renamerLogger->info("[RENAMING] Unsorted folder case -- We'll ignore any previous errors");
						$unsortedFolderAlreadyChecked = true;

                        //TODO: CHeck only for message in log: No files selected for processing
                        if (intval($exitCode) !== 0) {
                            $polls = 0;
                            $renamerLogger->warn("[RENAMING] The renamer script returned non-zero code -- Check Unsorted folder for unprocessed files");
                        } else {
                            $renamerLogger->debug("[RENAMING] Renamer with PID $pid finished processing Unsorted folder -- Empty or successful processing");
                            $this->torrentService->processTorrentsAfterRenaming($renamerLogFilePath, $torrentsToRename);
                        }

					} else {

						if (intval($exitCode) !== 0) {
							$renamerLogger->error("[RENAMING] Error executing renamer process with PID $pid, non-zero exit code");
							$this->logger->error("[RENAMING] Error executing renamer process with PID $pid, non-zero exit code from filebot, continue polling -- polls = $polls");

							$failedPolls++;
							$polls++;

							if ($polls > 10 && $failedPolls > 3) {
								$this->processManager->killRenamerProcessIfRunning();
							}

						} else {

							$polls = 0;
						}

                        $renamerLogger->debug("[RENAMING] Renamer with PID $pid finished processing -- continue after renaming...");
                        $this->torrentService->processTorrentsAfterRenaming($renamerLogFilePath, $torrentsToRename);
					}

				} else {

					$this->renamerLogger->debug("[RENAMER] No torrents in DOWNLOAD_COMPLETED state found -- polls = $polls");

					$polls++;

					if ($polls > 10) {
						$this->processManager->killRenamerProcessIfRunning();
					}

				}

				if (file_exists($terminatedFile)) {
					$this->renamerLogger->debug("[RENAMING] Terminated renamer worker on demand");
					$terminated = true;
				}

				gc_collect_cycles();
				sleep(10);
			}

		} catch (\Exception $e) {
			$this->logger->error("Error executing Renamer process with PID $pid -- stopping" . $e->getMessage() . " -- " . $e->getTraceAsString());
		} finally {
			unlink($pidFile);
			if (file_exists($terminatedFile)) {
				unlink($terminatedFile);
			}
		}
	}

    /**
     * @param $torrentsToRename
     * @param MediaCenterSettings $mediacenterSettings
     * @param $processPid
     * @param $isUnsortedFolder
     * @param null $xbmcHost
     * @return array
     */
    public function prepareRenameScriptToExecute($torrentsToRename, MediaCenterSettings $mediacenterSettings, $processPid, $isUnsortedFolder, $xbmcHost = null) {

		$appRoot = $this->kernel->getRootDir();
		$filePath = $appRoot . "/" . self::RENAME_SCRIPT_PATH;
        $filebotScriptsPath =  $appRoot . "/" . self::FILEBOT_SCRIPTS_PATH;

        $amcScriptPath = $this->symlinkCustomScripts($filebotScriptsPath, $mediacenterSettings->getProcessingTempPath());

		$this->renamerLogger->debug("[RENAMING] The renamer template script path is $filePath");
		$scriptContent = file_get_contents($filePath);

		$renamerLogFilePath = $mediacenterSettings->getProcessingTempPath() . "/rename_$processPid";
		$libraryBasePath = $mediacenterSettings->getBaseLibraryPath();

		if ($isUnsortedFolder && count($torrentsToRename) == 0) {

			$inputPathAsBashArray = "(" . "\"" . $mediacenterSettings->getBaseLibraryPath() . "/Unsorted" . "\"" . ")";
			$contentLanguages = '( "en" "es" )';

		} else {
			$inputPathAsBashArray = $this->torrentService->getTorrentsPathsAsBashArray($torrentsToRename, CommandType::RENAME_DOWNLOADS);
			$contentLanguages =  $this->torrentService->findLanguagesForTorrents($torrentsToRename);
		}


		$scriptContent = str_replace("%LOG_LOCATION%", $renamerLogFilePath, $scriptContent);
		$scriptContent = str_replace("%INPUT_PATHS%", $inputPathAsBashArray, $scriptContent);
		$scriptContent = str_replace("%VIDEO_LIBRARY_BASE_PATH%", $libraryBasePath, $scriptContent);
        $scriptContent = str_replace("%AMC_SCRIPT_PATH%", $amcScriptPath, $scriptContent);
        $scriptContent = str_replace("%CONTENT_LANGS%", $contentLanguages, $scriptContent);


		if ($xbmcHost != null) {
			$scriptContent = str_replace("%XBMC_HOSTNAME%", $xbmcHost, $scriptContent);
		}

		$scriptFilePath = $mediacenterSettings->getProcessingTempPath() . "/rename-filebot_$processPid.sh";
		file_put_contents($scriptFilePath, $scriptContent);
		file_put_contents($renamerLogFilePath . ".log","");

		return array($scriptFilePath, $renamerLogFilePath . ".log");
	}

    private function symlinkCustomScripts($filebotScriptsPath, $processingTempPath) {

        $this->renamerLogger->debug("[RENAMING] Symlinking custom Filebot scripts -- lib and AMC to temp path -- $filebotScriptsPath");
        $amcScriptPath = $processingTempPath . "/amc.groovy";
        $cleanerScriptPath = $processingTempPath . "/cleaner.groovy";
        $libScriptsPath = $processingTempPath . "/lib";

        // Ensure we delete them first, as they can be stale paths
        unlink($amcScriptPath);
        unlink($cleanerScriptPath);
        unlink($libScriptsPath);

        // Create symlinks
        symlink($filebotScriptsPath . "/amc.groovy",  $amcScriptPath);
        symlink($filebotScriptsPath . "/cleaner.groovy",  $cleanerScriptPath);
        symlink($filebotScriptsPath . "/lib", $libScriptsPath);

        return $amcScriptPath;
    }


	/**
     * Utility to delete files like /path/to/somename*
     */
	public function deleteFileUsingWildCard($pathWithWildcard) {
		array_map('unlink', glob($pathWithWildcard));
	}

	public function printMemoryUsage(){
		$this->renamerLogger->debug(sprintf('[RENAMER] Memory usage: (current) %dKB / (max) %dKB', round(memory_get_usage(true) / 1024), memory_get_peak_usage(true) / 1024));
	}
}
