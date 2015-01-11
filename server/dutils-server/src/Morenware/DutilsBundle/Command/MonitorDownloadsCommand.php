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
	
	/**
	 * Only 1 monitoring process at a time - check torrent status in Transmission and update states accordingly
	 * 
	 * @see \Symfony\Component\Console\Command\Command::execute()
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {

		$guid = GuidGenerator::generate();
		
		$terminatedFile = "/home/david/scripts/monitor.terminated";
		$pid = getmypid();
		$pidFile = "/home/david/scripts/monitor.pid";
		
		// Check race condition, only one monitoring process at a time
		if (file_exists($pidFile)) {
			return;
		}
		
		$handle = fopen($pidFile, "w");
		fwrite($handle, $pid);
		
		$output->writeln("[MONITOR-DOWNLOADS] Monitor process started with GUID $guid and PID $pid");
		$this->logger->debug("[MONITOR-DOWNLOADS] Monitor process started with GUID $guid and PID $pid");
		
		while(!file_exists($terminatedFile)) {
			$this->transmissionService->checkTorrentsStatus();
			$this->logger->debug("[MONITOR-DOWNLOADS] Checking status of torrents...");
			sleep(10);
		}
		
		if (file_exists($terminatedFile)) {
			$this->logger->info("Terminated monitoring worker with GUID $guid on demand");
		} else {
			$this->logger->warn("Terminated monitoring worker with GUID $guid due to unknown reason!");
		}
		
		unlink($pidFile);
		unlink($terminatedFile);
	}
	
	
	
	
	
}