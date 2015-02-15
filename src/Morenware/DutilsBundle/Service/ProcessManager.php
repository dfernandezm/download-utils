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
	
	/** @DI\Inject("kernel") */
	public $kernel;
	
	const TEMP_AREA_SCRIPT_EXECUTION_PATH = "/home/david/scripts";
	const TEMPLATE_NOTIFY_SCRIPT_PATH = "scripts/notify.sh";
	const TEMPLATE_COMMAND_SCRIPT_PATH = "scripts/executeCommand.sh";
	const MONITOR_DOWNLOADS_COMMAND_NAME = "dutils:monitorDownloads";
	const RENAME_COMMAND_NAME = "dutils:rename";
	
	public function getOverallTimeout() {
		// No more than 2 hours running
		return 2 * 60 * 60;
	}
	
	public function getIdleTimeout() {
		// No more than 2 minutes idle
		return 10 * 60;
	}
	
	//TODO: refactor to use generic method startSymfonyCommandAsynchronously
	public function startDownloadsMonitoring() {
		if (!$this->isMonitorDownloadsRunning()) {
			$processToExecute = "sh " . $this->prepareScriptToExecuteSymfonyCommand(CommandType::MONITOR_DOWNLOADS, true);
			$this->logger->info("Starting process to monitor downloads in Transmission: $processToExecute");
			$process = new Process($processToExecute);
			$process->setTimeout($this->getOverallTimeout());
			$process->setIdleTimeout($this->getIdleTimeout());
			$process->start();
			return $process;	
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
		
		try {
			
			$process = null;
		
			switch($command) {
				case CommandType::RENAME_DOWNLOADS:
					$scriptToExecute = $this->prepareScriptToExecuteSymfonyCommand(CommandType::RENAME_DOWNLOADS);
					$processToExecute = "sh " . $scriptToExecute;
					$this->logger->info("Starting Symfony command asynchronously: ". $processToExecute);
					$process = new Process($processToExecute);
					$process->setTimeout($this->getOverallTimeout());
					$process->setIdleTimeout($this->getIdleTimeout());
					$process->start();
					break;
				case CommandType::NOTIFY:
					//TODO: wrap in a command to invoke locally maybe better? and use a call to invoke remotely...
					$notifyCall = "http://local-dutils/api/notify/finished";
					$scriptToExecute = $this->prepareScriptToExecuteNotifyCall($notifyCall);
					$processToExecute = "sh " . $scriptToExecute;
					$this->logger->info("Executing notification to $notifyCall asynchronously");
					$process = new Process($processToExecute);
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
		return file_exists("/home/david/scripts/monitor.pid");
	}
	
	
	private function prepareScriptToExecuteNotifyCall($notifyCallUrl) {
		
		$this->logger->debug("Preparing script to notify");
		
		$appRoot =  $this->kernel->getRootDir();
		
		$filePath = $appRoot . "/" . self::TEMPLATE_NOTIFY_SCRIPT_PATH;
		
		$this->logger->debug("The template script path is $filePath");
		
		$scriptContent = file_get_contents($filePath);

		$scriptContent = str_replace("%NOTIFY_URL%", $notifyCallUrl, $scriptContent);
		
		$scriptFilePath = self::TEMP_AREA_SCRIPT_EXECUTION_PATH."/notify.sh";
		
		file_put_contents($scriptFilePath, $scriptContent);
		
		$this->logger->debug("The script is in path $scriptFilePath");
		
		return $scriptFilePath;
	}
	
	public function prepareScriptToExecuteSymfonyCommand($command, $executableByAll = false) {
		
		$this->logger->debug("Preparing script to execute Symfony command $command");
		
		$appRoot =  $this->kernel->getRootDir();
		$filePath = $appRoot . "/" . self::TEMPLATE_COMMAND_SCRIPT_PATH;
		
		$this->logger->debug("The template script path is $filePath");
		
		$scriptContent = file_get_contents($filePath);
		
		//TODO: not needed the str replace if scripts folder is inside app
		$scriptContent = str_replace("%SYMFONY_APP_ROOT%", str_replace("/app","",$appRoot), $scriptContent);
		
		$scriptFilePath = "";
		
		if ($command == CommandType::MONITOR_DOWNLOADS) {
			$scriptContent = str_replace("%COMMAND_NAME%", self::MONITOR_DOWNLOADS_COMMAND_NAME, $scriptContent);
			$scriptFilePath = self::TEMP_AREA_SCRIPT_EXECUTION_PATH . "/monitor.sh";
		} else if ($command == CommandType::RENAME_DOWNLOADS) {
			$scriptContent = str_replace("%COMMAND_NAME%", self::RENAME_COMMAND_NAME, $scriptContent);
			$scriptFilePath = self::TEMP_AREA_SCRIPT_EXECUTION_PATH . "/rename.sh";
		} else if ($command == CommandType::FETCH_SUBTITLES) {
			$scriptContent = str_replace("%COMMAND_NAME%", self::FETCH_SUBTITLES_COMMAND_NAME, $scriptContent);
			$scriptFilePath = self::TEMP_AREA_SCRIPT_EXECUTION_PATH . "/fetch-subtitles.sh";
		}
		
		file_put_contents($scriptFilePath, $scriptContent);
		$this->logger->debug("The script is in path $scriptFilePath");
		
		if ($executableByAll) {
			$this->logger->debug("Writing script $scriptFilePath");
			chmod($scriptFilePath, 0755);
		}

		return $scriptFilePath;
	}
	
	public function stopMonitoring() {
	
		$monitorPidFile = self::TEMP_AREA_SCRIPT_EXECUTION_PATH . "/monitor.pid";
		$monitorTerminatedFile = self::TEMP_AREA_SCRIPT_EXECUTION_PATH . "/monitor.terminated";
		
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
		$this->logger->debug("Starting process asynchronously...");
		return $process;
	}
	
	public function startProcessAsynchronouslyWithCallback($commandLineExecution, $waitCallback = null) {
		$process = $this->startProcessAsynchronously($commandLineExecution);
		
		if ($waitCallback != null) {
			// Black magic of arguments, closures, use: manage to pass in the $process to enable the callback to stop it
			$process->wait(function($type, $buffer) use ($process, $waitCallback) {
				$waitCallback($type, $buffer, $process);
			});
		}
		
		return $process;
	}
	
	public function stopRenamer() {
	
		$renamerPidFile = self::TEMP_AREA_SCRIPT_EXECUTION_PATH . "/renamer.pid";
		$renamerTerminatedFile = self::TEMP_AREA_SCRIPT_EXECUTION_PATH . "/renamer.terminated";
		
		if (file_exists($renamerPidFile)) {
			$this->logger->info("Flagging stop for renamer process");
			fopen($renamerTerminatedFile,"w");
		} else {
			$this->logger->warn("Looks like there is no renamer process running");
		}
	}
}