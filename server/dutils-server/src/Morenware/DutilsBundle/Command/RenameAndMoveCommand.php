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

	
	// The script which actually performs a full rename of the main folder
	const RENAME_SCRIPT = "scripts/rename-filebot.sh";
	
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
		$logger->info("Executing renamer command");
		
		$terminatedFile = "/home/david/scripts/renamer.terminated";
		$pid = getmypid();
		$pidFile = "/home/david/scripts/renamer.pid";
		
		// Check race condition, only one rename at a time
		if (file_exists($pidFile)) {
			$logger->debug("There is already one renamer process running -- exiting");
			return;
		}
		
		$handle = fopen($pidFile, "w");
		fwrite($handle, $pid);
		
		// Perform substitutions in the template renamer script
		$scriptToExecute = $this->prepareRenameScriptToExecute();	
		
		$output->writeln("Renamer process started with PID $pid");
		$logger->info("Renamer command started with PID $pid");
		
	
		if (!file_exists($terminatedFile)) {

			$logger->debug("The script to execute is: \n".$scriptToExecute);
			
			$waitCallback = function ($type, $buffer, $process) use ($logger, $terminatedFile) {
					
 				$logger->debug("Monitoring process execution...");
 				$logger->debug("Output: ".$buffer);
 				
 				if (file_exists($terminatedFile)) {
 					$logger->info("Terminated renamer worker on demand");
 					$process->stop();
 				}
 			};

 			// By opening a new shell we avoid the execution permission
			$commandLineExec = "sh " . $scriptToExecute;
 			$this->processManager->startProcessAsynchronously($commandLineExec, $waitCallback);

 			$logger->debug("Finishing renamer");
 			
		}
				
		unlink($pidFile);
		unlink($terminatedFile);
		unlink($scriptToExecute);

	}
	
	public function prepareRenameScriptToExecute() {
		
		$appRoot =  $this->kernel->getRootDir();
		$filePath = $appRoot."/".self::RENAME_SCRIPT;
		
		$this->logger->debug("The renamer template script path is $filePath");
		
		$scriptContent = file_get_contents($filePath);
		$scriptContent = str_replace("%VIDEO_LIBRARY_BASE_PATH%", "/home/david/scripts/downloads", $scriptContent);
		$scriptContent = str_replace("%BASE_DOWNLOADS_PATH%", "/mediacenter/torrents", $scriptContent);
		$scriptContent = str_replace("%GMAIL_USER%", "dfmorenza", $scriptContent);
		$scriptContent = str_replace("%GMAIL_PASSWORD%", "ZVCv8syN", $scriptContent);
		$scriptContent = str_replace("%XBMC_HOSTNAME%", "raspbmc", $scriptContent);
		
		$scriptFilePath = "/home/david/scripts/rename-filebot.sh";
		
		file_put_contents($scriptFilePath, $scriptContent);
		
		return $scriptFilePath;
	}
	
	
	public function deleteFileUsingWildCard($pathWithWildcard) {
		array_map('unlink', glob($pathWithWildcard));
	}
	
	
}