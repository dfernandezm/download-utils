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

/** 
 * @Service("monitordownload.service") 
 * @Tag("console.command")
 */
class MonitorDownloadsCommand extends Command {
	
	private $logger;
	
	/** @DI\Inject("transmission.service") */
	public $transmissionService;
	
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
		->setName('dutils:monitorDownloads')
		->setDescription('Monitor Downloads in remote Transmission');
	}
	
	protected function execute(InputInterface $input, OutputInterface $output) {

		$terminatedFile = "/home/david/scripts/terminated.terminated";
		$pid = getmypid();
		$handle = fopen("/home/david/scripts/monitor.pid", "a");
		fwrite($handle, $pid);
		
		$output->writeln("Starting monitoring...");
		
		while(!file_exists($terminatedFile)) {
			$this->transmissionService->checkTorrentsStatus();
			$this->logger->debug("Checking status of torrents...");
			$output->writeln("Checking status of torrents...");
			$output->writeln("Dir ".__DIR__);
			sleep(10);
		}
	}
	
	
	
	
	
}