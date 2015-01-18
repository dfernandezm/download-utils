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
 * @Service("renamecommad.service") 
 * @Tag("console.command")
 */
class RenameAndMoveCommand extends Command {
	
	private $logger;
	
	/** @DI\Inject("processmanager.service") */
	public $processManager;
	
	/** @DI\Inject("kernel") */
	public $kernel;
	
	/** @DI\Inject("torrent.service") */
	public $torrentService;

	// The script which actually performs a full rename of the main folder
	const RENAME_SCRIPT_PATH = "scripts/rename-filebot.sh";
	
	/**
	 * @DI\InjectParams({
	 *     "logger"           = @DI\Inject("logger")
	 * })
	 *
	 */
	public function __construct($logger) {
	
		$this->logger = $logger;
		parent::__construct();
	}
	
	
	protected function configure() {
		$this
		->setName('dutils:rename')
		->setDescription('Rename files after download completion');
	}
	
	/**
	 * Only 1 renaming process at a time
	 * 
	 * @see \Symfony\Component\Console\Command\Command::execute()
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {
		
		$logger = $this->logger;
		
		$logger->info("[RENAMING] Initializing renamer process");
		
		$terminatedFile = "/home/david/scripts/renamer.terminated";
		$pid = getmypid();
		$pidFile = "/home/david/scripts/renamer.pid";
		
		// Check race condition, only one rename at a time
		if (file_exists($pidFile)) {
			$logger->debug("[RENAMING] There is already one renamer process running -- exiting");
			return;
		}
		
		$handle = fopen($pidFile, "w");
		fwrite($handle, $pid);
		
		// Perform substitutions in the template renamer script
		list($scriptToExecute, $renamerLogFilePath) = $this->prepareRenameScriptToExecute($pid, "raspbmc");	
		
		$output->writeln("[RENAMING] Renamer process started with PID $pid");
		$logger->info("[RENAMING] Renamer process started with PID $pid");
		
		if (!file_exists($terminatedFile)) {

			$logger->debug("[RENAMING] The script to execute is $scriptToExecute");
			
			$waitCallback = function ($type, $buffer, $process) use ($logger, $terminatedFile) {
					
 				$logger->debug("[RENAMING] Monitoring process execution. Output is \n $buffer");
 				
 				if (file_exists($terminatedFile)) {
 					$logger->info("[RENAMING] Terminated renamer worker on demand");
 					$process->stop();
 				}
 			};

 			// By opening a new shell we avoid the execution permission
			$commandLineExec = "sh " . $scriptToExecute;
			
			// We provide a callback, so the process is not asynchronous in this case, blocks until completed
 			$this->processManager->startProcessAsynchronouslyWithCallback($commandLineExec, $waitCallback);

 			$logger->debug("[RENAMING] Renamer with PID $pid finished processing");
 			
		} else {
			$logger->debug("Terminated file found -- terminating");
			$output->writeln("Terminated file found -- terminating");
			unlink($terminatedFile);
		}
				
		unlink($pidFile);
		
		//Read the log to detect torrent names (match by name) and update state
		//TODO: Check exit status!!
		$this->torrentService->processTorrentsAfterRenaming($renamerLogFilePath);

	}
	
	public function prepareRenameScriptToExecute($processPid, $xbmcHost = null) {
		
		$appRoot =  $this->kernel->getRootDir();
		$filePath = $appRoot."/".self::RENAME_SCRIPT_PATH;
		
		$this->logger->debug("The renamer template script path is $filePath");
		
		$scriptContent = file_get_contents($filePath);
		
		$renamerLogFilePath = "/home/david/scripts/rename_$processPid.log"; 
		$scriptContent = str_replace("%LOG_LOCATION%", $renamerLogFilePath, $scriptContent);
		$scriptContent = str_replace("%VIDEO_LIBRARY_BASE_PATH%", "/mediacentertest", $scriptContent);
		$scriptContent = str_replace("%BASE_DOWNLOADS_PATH%", "/home/david/scripts/downloads", $scriptContent);
		
		if ($xbmcHost != null) {
			$scriptContent = str_replace("%XBMC_HOSTNAME%", $xbmcHost, $scriptContent);
		}
		
		$scriptFilePath = "/home/david/scripts/rename-filebot_$processPid.sh";
		
		file_put_contents($scriptFilePath, $scriptContent);
		
		$this->logger->debug("Writing script $scriptFilePath with 0755 permission - umask 022");
		chmod($scriptFilePath, 0755);
		
		return array($scriptFilePath, $renamerLogFilePath);
	}
	
	//Utility to delete files like /path/to/somename*
	public function deleteFileUsingWildCard($pathWithWildcard) {
		array_map('unlink', glob($pathWithWildcard));
	}
	
	
}