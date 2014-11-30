<?php

namespace Morenware\DutilsBundle\Service;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Process\Process;

/** @Service("processmanager.service") */
class ProcessManager {
	
	private $monitorDownloadsProcess;
	
	public function startDownloadsMonitoring() {
		
		if (!$this->isMonitorDownloadsRunning()) {

			//TODO: substitute this -> $this->get('kernel')->getRootDir() in the script to run;
			
			$scriptRoot = "/home/david/scripts";
			$processToExecute = "sh $scriptRoot/monitorDownloads.sh";
			$process = new Process($processToExecute);
			$process->start();	
			$this->monitorDownloadsProcess = $process;
		}
	}
	
	
	public function isMonitorDownloadsRunning() {
		return isset($this->monitorDownloadsProcess) && $this->monitorDownloadsProcess->isRunning();
	}
	
	public function writeScriptToExecuteCommand($scriptName, $command) {
		//TODO:
	}
}