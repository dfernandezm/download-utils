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
	
	//Only one of this for now
	private $monitorDownloadsProcess;
	public static $monitorDownloadsProcessGuid;
	
	const TEMP_AREA_SCRIPT_EXECUTION_PATH = "/home/david/scripts";
	const TEMPLATE_COMMAND_SCRIPT_PATH = "scripts/executeCommand.sh";
	const MONITOR_DOWNLOADS_COMMAND_NAME = "dutils:monitorDownloads";
	
	public function startDownloadsMonitoring() {
		
		if (!$this->isMonitorDownloadsRunning()) {
			$guid = GuidGenerator::generate();
			$processToExecute = "sh ".$this->prepareScriptToExecuteCommand(CommandType::MONITOR_DOWNLOADS, $guid);
			$this->logger->info("Starting process to monitor downloads in Transmission: $processToExecute");
			$process = new Process($processToExecute);
			$process->start();	
		} else {
			$this->logger->debug("There is already one monitoring process running");
		}
	}

	public function isMonitorDownloadsRunning() {
		return file_exists("/home/david/scripts/monitor.pid");
	}
	
	public function prepareScriptToExecuteCommand($command, $guid) {
		
		$this->logger->debug("Preparing script to execute command...");
		
		$appRoot =  $this->kernel->getRootDir();
		$filePath = $appRoot."/".self::TEMPLATE_COMMAND_SCRIPT_PATH;
		
		$this->logger->debug("The template script path is $filePath");
		
		$scriptContent = file_get_contents($filePath);
		$scriptContent = str_replace("%SYMFONY_APP_ROOT%", str_replace("/app","",$appRoot), $scriptContent);
		
		$scriptFilePath = "";
		
		if ($command == CommandType::MONITOR_DOWNLOADS) {
			$scriptContent = str_replace("%COMMAND_NAME%", self::MONITOR_DOWNLOADS_COMMAND_NAME, $scriptContent);
			$scriptFilePath = self::TEMP_AREA_SCRIPT_EXECUTION_PATH."/monitor.sh";
			$this->logger->debug("The script being written is in path $scriptFilePath");
			file_put_contents($scriptFilePath, $scriptContent);
		}

		return $scriptFilePath;
	}
	
	public function stopMonitoring() {
		
		$guid = $this->monitorDownloadsProcessGuid;
		
		if (isset($guid)) {
			$this->logger->info("Flagging stop for monitoring process with GUID $guid");
			fopen("/home/david/scripts/monitor.terminated","w");
		} else {
			$this->logger->warn("Looks like there is no monitoring process running");
		}
	
	}
}