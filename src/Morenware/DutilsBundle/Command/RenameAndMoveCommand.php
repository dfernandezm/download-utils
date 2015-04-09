<?php
namespace Morenware\DutilsBundle\Command;

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

/** 
 * @Service("renamecommand.service") 
 * @Tag("console.command")
 */
class RenameAndMoveCommand extends Command {
	
	private $logger;
	
	private $renamerLogger;
	
	/** @DI\Inject("processmanager.service") */
	public $processManager;
	
	/** @DI\Inject("kernel") */
	public $kernel;
	
	/** @DI\Inject("torrent.service") */
	public $torrentService;
	
	/** @DI\Inject("settings.service") */
	public $settingsService;

	// The script which actually performs a full rename of the downloads main folder
	const RENAME_SCRIPT_PATH = "scripts/multiple-rename-filebot.sh";
	
	// File whose presence indicates flags the process for termination
	const TERMINATED_FILE_NAME = "renamer.terminated";
	
	// File containing the PID of the renamer process. Its presence indicates that one and only
	// one is currently running
	const PID_FILE_NAME = "renamer.pid";
	
	
	/**
	 * @DI\InjectParams({
	 *     "logger" = @DI\Inject("logger"),
	 *     "renamerLogger" =  @DI\Inject("monolog.logger.renamer")
	 * })
	 *
	 */
	public function __construct($logger, $renamerLogger) {
	
		$this->logger = $logger;
		$this->renamerLogger = $renamerLogger;
		parent::__construct();
	}
	
	
	protected function configure() {
		$this
		->setName('dutils:renamer')
		->setDescription('Rename files after download completion');
	}
	
	/**
	 * Only 1 renaming process at a time
	 * 
	 * @see \Symfony\Component\Console\Command\Command::execute()
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {
		
		$logger = $this->logger;
		$pid = getmypid();
		$logger->info("[RENAMING] Starting Renamer process with PID $pid");
		$this->renamerLogger->info("[RENAMING] Starting Renamer process with PID $pid");
		$output->writeln("[RENAMING] Renamer process started with PID $pid");
			
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
	
		//TODO: create poll loop every 30 seconds checking the DB for torrents in DOWNLOAD_COMPLETED state
		$terminated = false;
		
		if (file_exists($terminatedFile)) {
			$this->renamerLogger->debug("[RENAMING] Terminated renamer worker on demand");
			$terminated = true;
		}
		
		try {
			
			while (!$terminated) {
				$this->renamerLogger->debug("[RENAMING] Checking if there are any torrents to rename...");
				$this->printMemoryUsage();
				$torrentsToRename = $this->torrentService->findTorrentsByState(TorrentState::DOWNLOAD_COMPLETED);
				
				if (count($torrentsToRename) > 0) {
					$guid = GuidGenerator::generate();	
					$this->renamerLogger->debug("[RENAMING] Detected torrents to rename");
					
					// Perform substitutions in the template renamer script
					list($scriptToExecute, $renamerLogFilePath) = $this->prepareRenameScriptToExecute($torrentsToRename, $mediacenterSettings, $pid . "_" . $guid, $mediacenterSettings->getXbmcHostOrIp());
					$this->renamerLogger->debug("[RENAMING] The script to execute is $scriptToExecute");
					$renamerLogger = $this->renamerLogger;
					
					// Define callback function to monitor real time output of the process
					$waitCallback = function ($type, $buffer, $process) use ($renamerLogger, $terminatedFile) {
					
						$renamerLogger->debug("[RENAMING] ==> $buffer");
							
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
						
					$renamerLogger->error("[RENAMING] Renamer process exitCode is $exitCodeText ==> $exitCode");
						
					if (intval($exitCode) !== 0) {
						$renamerLogger->error("[RENAMING] Error executing renamer process with PID $pid, non-zero exit code");
						$this->logger->error("[RENAMING] Error executing renamer process with PID $pid, non-zero exit code from filebot, continue polling....");
						
					}
						
					$renamerLogger->debug("[RENAMING] Renamer with PID $pid finished processing -- starting further checks...");
						
					$this->torrentService->processTorrentsAfterRenaming($renamerLogFilePath);
							
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
	
	public function prepareRenameScriptToExecute($torrentsToRename, $mediacenterSettings, $processPid, $xbmcHost = null) {
		
		$appRoot = $this->kernel->getRootDir();
		$filePath = $appRoot . "/" . self::RENAME_SCRIPT_PATH;
		
		$this->renamerLogger->debug("[RENAMING] The renamer template script path is $filePath");
		
		$scriptContent = file_get_contents($filePath);
		
		$renamerLogFilePath = $mediacenterSettings->getProcessingTempPath() . "/rename_$processPid"; 
		$baseDownloadsPath = $mediacenterSettings->getBaseDownloadsPath();
		$libraryBasePath = $mediacenterSettings->getBaseLibraryPath();

		$inputPathAsBashArray = $this->torrentService->getTorrentsPathsAsBashArray($torrentsToRename, $baseDownloadsPath, CommandType::RENAME_DOWNLOADS);
		
		$scriptContent = str_replace("%LOG_LOCATION%", $renamerLogFilePath, $scriptContent);
		$scriptContent = str_replace("%INPUT_PATHS%", $inputPathAsBashArray, $scriptContent);
		$scriptContent = str_replace("%VIDEO_LIBRARY_BASE_PATH%", $libraryBasePath, $scriptContent);
		
		if ($xbmcHost != null) {
			$scriptContent = str_replace("%XBMC_HOSTNAME%", $xbmcHost, $scriptContent);
		}
		
		$scriptFilePath = $mediacenterSettings->getProcessingTempPath() . "/rename-filebot_$processPid.sh";
		file_put_contents($scriptFilePath, $scriptContent);
		file_put_contents($renamerLogFilePath . ".log","");
				
		return array($scriptFilePath, $renamerLogFilePath . ".log");
	}
	
	// Utility to delete files like /path/to/somename*
	public function deleteFileUsingWildCard($pathWithWildcard) {
		array_map('unlink', glob($pathWithWildcard));
	}
	
	public function printMemoryUsage(){
		$this->renamerLogger->debug(sprintf('[RENAMER] Memory usage: (current) %dKB / (max) %dKB', round(memory_get_usage(true) / 1024), memory_get_peak_usage(true) / 1024));
	}
}