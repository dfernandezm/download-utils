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

/** 
 * @Service("transcoding.service") 
 * @Tag("console.command")
 */
class TranscodingCommand extends Command {
	
	private $logger;
	
	/** @DI\Inject("processmanager.service") */
	public $processManager;
	
	/** @DI\Inject("kernel") */
	public $kernel;
	

	// The script which actually performs a full rename of the main folder
	const TRANSCODE_SCRIPT = "scripts/transcode.sh";
	
	/**
	 * @DI\InjectParams({
	 *     "logger" = @DI\Inject("logger")
	 * })
	 *
	 */
	public function __construct($logger) {
	
		$this->logger = $logger;
		parent::__construct();
	}
	
	
	protected function configure() {
		$this
		->setName('dutils:transcode')
		->setDescription('Transcode media to reduce size for iPad/Mobile');
	}
	
	/**
	 * @see \Symfony\Component\Console\Command\Command::execute()
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {

		$guid = GuidGenerator::generate();
		
		$inputFilePath = "24/Season\ 9/24\ 9x11.mkv";
		
		$outputFilePath = "24/Season\ 9/24\ 9x11.mp4";
		
		$terminatedFile = "/home/david/scripts/transcode-$guid.terminated";
		$pid = getmypid();
		$pidFile = "/home/david/scripts/transcode-$guid.pid";
		
		$handle = fopen($pidFile, "w");
		fwrite($handle, $pid);
		
		$output->writeln("Transcode started with GUID $guid and PID $pid");
		
		$logger = $this->logger;
		
		$scriptToExecute = $this->prepareTranscodeScriptToExecute($guid, $inputFilePath, $outputFilePath);
		
		if (!file_exists($terminatedFile)) {

			$logger->debug("The script to execute is: \n".$scriptToExecute);
			
			$waitCallback = function ($type, $buffer, $process) use ($logger, $terminatedFile, $guid) {

				//TODO: output errors!!
 				$logger->debug("Monitoring process execution...");
 				$logger->debug("Output: ".$buffer);
 				
 				if (file_exists($terminatedFile)) {
 					$logger->info("Terminated transcoder worker on demand - GUID $guid");
 					$process->stop();
 				}
 			};

 			// By opening a new shell we avoid the execution permission
			$commandLineExec = "sh " . $scriptToExecute;
 			$this->processManager->startProcessAsynchronously($commandLineExec, $waitCallback);

 			$logger->debug("Finishing transcoder with GUID - $guid");
 			
		}
				
		unlink($pidFile);
		//unlink($terminatedFile);
		//unlink($scriptToExecute);
	}
	
	
	public function prepareTranscodeScriptToExecute($guid, $inputFilePath, $outputFilePath) {
	
		$appRoot =  $this->kernel->getRootDir();
		$filePath = $appRoot."/".self::TRANSCODE_SCRIPT;
	
		$this->logger->debug("The renamer template script path is $filePath");
	
		$scriptContent = file_get_contents($filePath);
		$scriptContent = str_replace("%GUID%", $guid, $scriptContent);
		$scriptContent = str_replace("%INPUT_PATH%", $inputFilePath, $scriptContent);
		$scriptContent = str_replace("%OUTPUT_PATH%", $outputFilePath, $scriptContent);
		
		$scriptFilePath = "/home/david/scripts/transcode-$guid.sh";
	
		file_put_contents($scriptFilePath, $scriptContent);
	
		return $scriptFilePath;
	}
	
	
}