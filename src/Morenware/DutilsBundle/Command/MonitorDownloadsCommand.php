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
use Morenware\DutilsBundle\Entity\MediaCenterSettings;
use Assetic\Exception\Exception;

/** 
 * @Service("monitordownload.service") 
 * @Tag("console.command")
 */
class MonitorDownloadsCommand extends Command {
	
	private $logger;
	
	/** @DI\Inject("transmission.service") */
	public $transmissionService;
	
	/** @DI\Inject("settings.service") */
	public $settingsService;
	
	/**
	 * @DI\InjectParams({
	 *     "logger" = @DI\Inject("monolog.logger.monitor")
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

		try {
			
			$guid = GuidGenerator::generate();
			
			$mediacenterSettings = $this->settingsService->getDefaultMediacenterSettings();
			
			$terminatedFile = $mediacenterSettings->getProcessingTempPath() . "/monitor.terminated";
			$pid = getmypid();
			$pidFile = $mediacenterSettings->getProcessingTempPath() . "/monitor.pid";
			
			// Check race condition, only one monitoring process at a time
			if (file_exists($pidFile)) {
				$this->logger->debug("[MONITOR-DOWNLOADS] PID file already exists, there must be already one monitor process running -- exiting");
				return;
			}
			
			// Write pidfile
			$handle = fopen($pidFile, "w");
			fwrite($handle, $pid);
			fclose($handle);
			
			$this->logger->info("[MONITOR-DOWNLOADS] Monitor process started with GUID $guid and PID $pid");
			
			while(!file_exists($terminatedFile)) {
				$this->printMemoryUsage();	
				$this->transmissionService->checkTorrentsStatus();
				sleep(10);
			}
			
			if (file_exists($terminatedFile)) {
				$this->logger->info("Terminated monitoring worker with GUID $guid and PID $pid on demand");
			} else {
				$this->logger->warn("Terminated monitoring worker with GUID $guid and PID $pid due to unknown reason!");
			}
			
		} catch(\Exception $e) {
			$this->logger->error("Error occurred executing monitor process with GUID $guid and PID $pid", $e->getMessage());
		} finally {
			unlink($pidFile);
			unlink($terminatedFile);
		}
	}
	
	public function printMemoryUsage(){
		$this->logger->debug(sprintf('Memory usage: (current) %dKB / (max) %dKB', round(memory_get_usage(true) / 1024), memory_get_peak_usage(true) / 1024));
	}
}