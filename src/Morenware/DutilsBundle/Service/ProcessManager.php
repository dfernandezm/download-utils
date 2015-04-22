<?php

namespace Morenware\DutilsBundle\Service;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Process\Process;
use Morenware\DutilsBundle\Service\CommandType;
use Morenware\DutilsBundle\Command\MonitorDownloadsCommand;
use Morenware\DutilsBundle\Util\GuidGenerator;


/** @Service("processmanager.service") */
class ProcessManager {
	
	/** @DI\Inject("logger") */
	public $logger;
	
	/** @DI\Inject("monolog.logger.renamer") */
	public $renamerLogger;
	
	/** @DI\Inject("settings.service") */
	public $settingsService;
	
	/** @DI\Inject("kernel") */
	public $kernel;
	
	const TEMPLATE_NOTIFY_SCRIPT_PATH = "scripts/notify.sh";
	const TEMPLATE_COMMAND_SCRIPT_PATH = "scripts/executeCommand.sh";
	const MONITOR_DOWNLOADS_COMMAND_NAME = "dutils:monitorDownloads";
	const RENAME_COMMAND_NAME = "dutils:renamer";
    const NOTIFY_COMMAND_NAME = "dutils:notifyTorrentDone";
	const FETCH_SUBTITLES_COMMAND_NAME = "dutils:subtitles";
	
	public function getOverallTimeout() {
		// No more than 6 hours running
		return 6 * 60 * 60;
	}
	
	public function getIdleTimeout() {
		// No more than 10 minutes idle
		return 10 * 60;
	}
	
	public function startDownloadsMonitoring() {
		
		if (!$this->isMonitorDownloadsRunning()) {
			return $this->startSymfonyCommandAsynchronously(CommandType::MONITOR_DOWNLOADS);	
		} else {
			$this->logger->debug("There is already one monitoring process running");
		}
	}
	
	/**
	 * Starts a Symfony Command in a separate process which is run asynchronously.
	 * 
	 * @param $command the Command Type to be created and executed
	 * @return $process a Process object representing the command started, to further control execution or null if no process could have been started
	 */
	public function startSymfonyCommandAsynchronously($command) {
		$this->renamerLogger->info("Starting Symfony command asynchronously: ". $command);
		try {
			
			$process = null;
			$appRoot =  $this->kernel->getRootDir();
			switch($command) {
				case CommandType::RENAME_DOWNLOADS:
					$processToExecute = "php console " . self::RENAME_COMMAND_NAME . " -e prod --no-debug";
					$this->renamerLogger->info("Starting Symfony command asynchronously: ". $processToExecute);
					$process = new Process($processToExecute);
					$process->setWorkingDirectory($appRoot);
					$process->setTimeout($this->getOverallTimeout());
					$process->setIdleTimeout($this->getIdleTimeout());
					$process->start();
					$this->renamerLogger->info("Process for renaming started: ". $process->getStatus() . " with PID " . $process->getPid());
					break;
				case CommandType::NOTIFY:
					$scriptToExecute = $this->prepareScriptToExecuteNotifyCall();
					$processToExecute = "sh " . $scriptToExecute;
					$this->logger->info("Executing notification to call asynchronously");
					$process = new Process($processToExecute);
					$process->setTimeout($this->getOverallTimeout());
					$process->setIdleTimeout($this->getIdleTimeout());
					$process->start();
					$this->logger->info("Process started: " . $process->getStatus());
					break;
				case CommandType::FETCH_SUBTITLES:
					$this->renamerLogger->info("Preparing fetch subtitles ");
					$processToExecute = "php console " . self::FETCH_SUBTITLES_COMMAND_NAME . " -e prod --no-debug";
					$this->renamerLogger->info("Starting Symfony command asynchronously: ". $processToExecute . " from $appRoot");
					$process = new Process($processToExecute);
					$process->setWorkingDirectory($appRoot);
					$process->setTimeout($this->getOverallTimeout());
					$process->setIdleTimeout($this->getIdleTimeout());
					$process->start();
					$this->renamerLogger->info("Process for subtitles started: ". $process->getStatus() . " with PID " . $process->getPid());
					break;
				case CommandType::MONITOR_DOWNLOADS:
					$processToExecute = "php console " . self::MONITOR_DOWNLOADS_COMMAND_NAME . " -e prod --no-debug";
					$this->logger->info("Starting process to monitor downloads in Transmission: $processToExecute");
					$process = new Process($processToExecute);
					$process->setWorkingDirectory($appRoot);
					$process->setTimeout($this->getOverallTimeout());
					$process->setIdleTimeout($this->getIdleTimeout());
					$process->start();
					break;
				default:
					$this->logger->warn("Unknown command provided -- fix code");
			}
		
			return $process;
			
		} catch(\Exception $e) {
			$this->logger->error("Error starting process for Symfony command $command: " . $e->getMessage() . " == " . $e->getTraceAsString());
			throw $e;
		}
	}
	
	
	public function isMonitorDownloadsRunning() {
		$mediacenterSettings = $this->settingsService->getDefaultMediacenterSettings();
		$processingPath = $mediacenterSettings->getProcessingTempPath();
		return file_exists( $processingPath . "/monitor.pid");
	}
	
	
	public function prepareScriptToExecuteNotifyCall() {
		
		$mediacenterSettings = $this->settingsService->getDefaultMediacenterSettings();
		
		//TODO: This is temporary, write the script in the shared path between the server running this app and the 
		// machine running transmission (which has to be accessible via http, normally http://localhost)
		$processingPath = $mediacenterSettings->getBaseLibraryPath();	
		
		$this->logger->debug("Preparing script to notify...");
		
		$appRoot =  $this->kernel->getRootDir();
		
		if ($mediacenterSettings->getIsRemote()) {
			$notifyCallUrl = "http://local-dutils/api/notify/finished";
			$filePath = $appRoot . "/" . self::TEMPLATE_NOTIFY_SCRIPT_PATH;
			$this->logger->debug("The template script for notification is in path $filePath");
			$scriptContent = file_get_contents($filePath);
			$scriptContent = str_replace("%NOTIFY_URL%", $notifyCallUrl, $scriptContent);
		} else {
			$filePath = $appRoot . "/" . self::TEMPLATE_COMMAND_SCRIPT_PATH;
			$this->logger->debug("The template script used for notification is in path $filePath");
			$scriptContent = file_get_contents($filePath);
			$appRootPath = str_replace("/app","",$appRoot);
			$scriptContent = str_replace("%SYMFONY_APP_ROOT%", $appRootPath, $scriptContent);
			$scriptContent = str_replace("%COMMAND_NAME%", self::NOTIFY_COMMAND_NAME, $scriptContent);
		}
		
		$scriptFilePath = $processingPath . "/notify.sh";
		file_put_contents($scriptFilePath, $scriptContent);
		chmod($scriptFilePath, 0755);
		$this->logger->debug("The script used to notify is in path $scriptFilePath");
		return $scriptFilePath;
	}
	
	public function stopMonitoring() {
		$mediacenterSettings = $this->settingsService->getDefaultMediacenterSettings();
		$processingPath = $mediacenterSettings->getProcessingTempPath();
		
		$monitorPidFile = $processingPath . "/monitor.pid";
		$monitorTerminatedFile = $processingPath . "/monitor.terminated";
		
		if (file_exists($monitorPidFile)) {
			$this->logger->info("Flagging stop for monitoring process");
			$file = fopen($monitorTerminatedFile,"w");
			fclose($file);
		} else {
			$this->logger->warn("Looks like there is no monitoring process running");
		}
	
	}
	
	/**
	 * Starts a generic Unix script / command in a separate, asynchronous process and retrieves a Process object
	 * to monitor it.
	 * 
	 * @param unknown $comandLineExecution
	 */
	public function startProcessAsynchronously($commandLineExecution) {
		$process = new Process($commandLineExecution);
		$process->setTimeout($this->getOverallTimeout());
		$process->setIdleTimeout($this->getIdleTimeout());
		$process->start();
		$this->logger->debug("Starting process asynchronously: " . $process->isStarted());
		return $process;
	}
	
	public function startProcessAsynchronouslyWithCallback($commandLineExecution, $waitCallback = null) {
		$process = $this->startProcessAsynchronously($commandLineExecution);
		
		if ($waitCallback != null) {
			//Monitor the process running using black magic of arguments, closures, use: manage to pass in the $process to enable the callback to stop it if needed
			$process->wait(function($type, $buffer) use ($process, $waitCallback) {
				$waitCallback($type, $buffer, $process);
			});
		}
		
		return $process;
	}
	
	public function stopRenamer() {
		$mediacenterSettings = $this->settingsService->getDefaultMediacenterSettings();
		$processingPath = $mediacenterSettings->getProcessingTempPath();
		
		$renamerPidFile = $processingPath . "/renamer.pid";
		$renamerTerminatedFile = $processingPath . "/renamer.terminated";
		
		if (file_exists($renamerPidFile)) {
			$this->logger->info("Flagging stop for renamer process");
			fopen($renamerTerminatedFile,"w");
		} else {
			$this->logger->warn("Looks like there is no renamer process running");
		}
	}
	
	public function isRenamerWorkerRunning() {
		
		$mediacenterSettings = $this->settingsService->getDefaultMediacenterSettings();
		$processingPath = $mediacenterSettings->getProcessingTempPath();
		
		$renamerPidFile = $processingPath . "/renamer.pid";
		
		if (file_exists($renamerPidFile)) {
			$this->logger->info("[RENAMING] There is already one renamer process running");
			return true;
		} else {
			return false;
		}
	}
	
	public function isSubtitleFetchWorkerRunning() {
		$mediacenterSettings = $this->settingsService->getDefaultMediacenterSettings();
		$processingPath = $mediacenterSettings->getProcessingTempPath();
		$subtitleFetchPidFile = $processingPath . "/subtitles.pid";
		
		if (file_exists($subtitleFetchPidFile)) {
			$this->logger->info("[SUBTITLES] There is already one subtitle fetcher process running");
			return true;
		} else {
			return false;
		}
	}
	
	public function startRenamerWorker() {
		if (!$this->isRenamerWorkerRunning()) {
			$this->startSymfonyCommandAsynchronously(CommandType::RENAME_DOWNLOADS);
		}
	}
	
	public function startSubtitleFetchWorker() {
		if (!$this->isSubtitleFetchWorkerRunning()) {
			$this->startSymfonyCommandAsynchronously(CommandType::FETCH_SUBTITLES);
		}
	}
	
	public function cleanupPidAndTerminatedFiles() {
		$mediacenterSettings = $this->settingsService->getDefaultMediacenterSettings();
		$processingPath = $mediacenterSettings->getProcessingTempPath();
		$this->deleteFileUsingWildcard($processingPath . "/*.pid");
		$this->deleteFileUsingWildcard($processingPath . "/*.terminated");
	}
	
	public function killWorkerProcessesIfRunning() {
		$mediacenterSettings = $this->settingsService->getDefaultMediacenterSettings();
		$processingPath = $mediacenterSettings->getProcessingTempPath();
		
		$monitorPidFile = $processingPath . "/monitor.pid";
		$renamerPidFile = $processingPath . "/renamer.pid";
		$subtitlePidFile = $processingPath . "/subtitles.pid";

		$monitorTerminatedFile = $processingPath . "/monitor.terminated";
		$renamerTerminatedFile = $processingPath . "/renamer.terminated";
		$subtitleTerminatedFile = $processingPath . "/subtitles.terminated";
		
		//First attempt gracefully kill by touching .terminated file, if still running, execute kill -9
		
		$this->logger->debug("Attempt gracefully shutdown of worker processes...");
		
		if (file_exists($monitorPidFile)) {
			$pid = trim(file_get_contents($monitorPidFile));
			if (file_exists("/proc/$pid")) {
				touch($monitorTerminatedFile);
			} else {
				$this->logger->debug("Monitor process wasn't running, deleting files");
				unlink($monitorPidFile);
			}
		}
		
		if (file_exists($renamerPidFile)) {
			$pid = trim(file_get_contents($renamerPidFile));
			if (file_exists("/proc/$pid")) {
				touch($renamerTerminatedFile);
			} else {
				$this->logger->debug("Renamer process wasn't running, deleting files");
				unlink($renamerPidFile);
			}
		}
		
		if (file_exists($subtitlePidFile)) {
			$pid = trim(file_get_contents($subtitlePidFile));
			if (file_exists("/proc/$pid")) {	
				touch($subtitleTerminatedFile);
			} else {
				$this->logger->debug("Subtitle process wasn't running, deleting files");
				unlink($subtitlePidFile);
			}
		}
	}
	
	public function deleteFileUsingWildcard($pathWithWildcard) {
		array_map('unlink', glob($pathWithWildcard));
	}
}