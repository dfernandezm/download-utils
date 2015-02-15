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

/** 
 * @Service("fetchsubscommand.service") 
 * @Tag("console.command")
 */
class FetchSubtitlesCommand extends Command {
	
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

	// The script
	const SUBTITLES_SCRIPT_PATH = "scripts/multiple-subtitle-filebot.sh";
	
	// File whose presence indicates flags the process for termination
	const TERMINATED_FILE_NAME = "subtitlefetcher.terminated";
	
	// File containing the PID of the subtitle fetcher process. Its presence indicates that one and only
	// one is currently running
	const PID_FILE_NAME = "subtitles.pid";
	
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
		->setName('dutils:subtitles')
		->setDescription('Fetch subtitles for files after being moved to the destination');
	}
	
	/**
	 * It will pick the torrents in RENAMED status
	 * 
	 * @see \Symfony\Component\Console\Command\Command::execute()
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {
		
		try {
			
			$logger = $this->logger;
			$pid = getmypid();
			$logger->info("[SUBTITLES] Starting Subtitle Fetch process with PID $pid");
			$output->writeln("[SUBTITLES] Starting Subtitle Fetch process with PID $pid");
			
			$mediacenterSettings = $this->settingsService->getDefaultMediacenterSettings();
			$processingTempPath = $mediacenterSettings->getProcessingTempPath();
		
			$this->renamerLogger->debug("[SUBTITLES] Read config from DB, processing temp path is $processingTempPath");
		
			$terminatedFile = $mediacenterSettings->getProcessingTempPath() . "/" . self::TERMINATED_FILE_NAME;
			$pidFile = $mediacenterSettings->getProcessingTempPath() . "/" . self::PID_FILE_NAME;
		
			// Check race condition, only one rename at a time
			if (file_exists($pidFile)) {
				$logger->info("[SUBTITLES] There is already one subtitle fetcher process running -- exiting");
				return;
			}
		
			// Write pid file
			$handle = fopen($pidFile, "w");
			fwrite($handle, $pid);
			
			// Perform substitutions in the template renamer script
			list($scriptToExecute, $renamerLogFilePath) = $this->prepareSubtitleScriptToExecute($mediacenterSettings, $pid);	
		
			if (!file_exists($terminatedFile)) {

				$this->renamerLogger->debug("[SUBTITLES] The script to execute is $scriptToExecute");
				$renamerLogger = $this->renamerLogger;
				
				// Define callback function to monitor real time output of the process
				$waitCallback = function ($type, $buffer, $process) use ($renamerLogger, $terminatedFile) {
					
 					$renamerLogger->debug("[SUBTITLES] ==> $buffer");
 					
 					if (file_exists($terminatedFile)) {
 						$renamerLogger->debug("[SUBTITLES] Terminated renamer worker on demand");
 						$process->stop();
 					}
 				};

 				// By opening a new shell we avoid the execution permission
				$commandLineExec = "sh " . $scriptToExecute;
			
				try {
					// We provide a callback, so the process is not asynchronous in this particular case, it blocks until completed or timeout
 					$process = $this->processManager->startProcessAsynchronouslyWithCallback($commandLineExec, $waitCallback);
						
 					$exitCode = $process->getExitCode();
 					$exitCodeText = $process->getExitCodeText();
 					
 					$renamerLogger->error("[SUBTITLES] Renamer process exitCode is $exitCodeText ==> $exitCode");
 					
 					if ($exitCode == null) {
 						$renamerLogger->error("[SUBTITLES] Error executing fetching subs process with PID $pid hasn't seem to be terminated, aborting");
 						$this->logger->error("[SUBTITLES] Error executing fetching subs process with PID $pid hasn't seem to be terminated, aborting");
 						throw new \Exception("[SUBTITLES] Error executing fetching subs subs process PID $pid", $exitCode, null);
 					} else if ($exitCode != 0) {
 						$renamerLogger->error("[SUBTITLES] Error executing fetching subs process with PID $pid ");
 						throw new \Exception("[SUBTITLES] Error executing fetching subs process PID $pid", $exitCode, null);
 					}
 					
				} catch (\Exception $e) {
					$renamerLogger->error("[SUBTITLES] Error executing fetching subs process with PID $pid: " . $e->getMessage() . " " . $e->getTraceAsString());
					$this->logger->error("[SUBTITLES] Error executing fetching subs process with PID $pid: " . $e->getMessage() . " " . $e->getTraceAsString());
					throw $e;
				}
				
 				$renamerLogger->debug("[SUBTITLES] Subtitle fetcher with PID $pid finished processing");
 				
 				$this->torrentService->finishProcessingAfterFetchingSubs();
 				
			} else {
				$renamerLogger->debug("[SUBTITLES] .terminated file found -- terminating execution");
				$output->writeln("[SUBTITLES] .terminated file found -- terminating execution");
			}
			
			gc_collect_cycles();
		
		} catch (\Exception $e) {
			$this->logger->error("Error executing Subtitle Fetcher process with PID $pid -- " . $e->getMessage() . " -- " . $e->getTraceAsString());		
		} finally {
			
			unlink($pidFile);
			unlink($terminatedFile);
		}
	}
	
	public function prepareSubtitleScriptToExecute($mediacenterSettings, $processPid) {
		
		$appRoot = $this->kernel->getRootDir();
		$filePath = $appRoot . "/" . self::SUBTITLES_SCRIPT_PATH;
		
		$this->renamerLogger->debug("[SUBTITLES] The renamer template script path is $filePath");
		
		$scriptContent = file_get_contents($filePath);
		
		$subtitlesLogFilePath = $mediacenterSettings->getProcessingTempPath() . "/subtitles_$processPid"; 
		$scriptContent = str_replace("%LOG_LOCATION%", $subtitlesLogFilePath, $scriptContent);
		
		$inputPathsAsBashArray = $this->torrentService->getRenamedTorrentsPathsAsBashArray($mediacenterSettings->getBaseLibraryPath());
		$scriptContent = str_replace("%INPUT_PATHS%", $inputPathsAsBashArray, $scriptContent);
		
		$scriptContent = str_replace("%SUBS_LANGUAGES%", "en,es", $scriptContent);
		
		$scriptFilePath = $mediacenterSettings->getProcessingTempPath() . "/subtitles-filebot_$processPid.sh";
		file_put_contents($scriptFilePath, $scriptContent);
				
		return array($scriptFilePath, $subtitlesLogFilePath . ".log");
	}
	
	// Utility to delete files like /path/to/somename*
	public function deleteFileUsingWildCard($pathWithWildcard) {
		array_map('unlink', glob($pathWithWildcard));
	}
}