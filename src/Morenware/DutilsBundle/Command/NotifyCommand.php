<?php
namespace Morenware\DutilsBundle\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;


use JMS\DiExtraBundle\Annotation as DI;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation\Tag;

/**
 * @Service("notifycommand.service")
 * @Tag("console.command")
 */
class NotifyCommand extends Command {

	/** @DI\Inject("transmission.service") */
	public $transmissionService;
	
	/** @DI\Inject("processmanager.service") */
	public $processManager;
	
	
	public function __construct() {
		parent::__construct();
	}
	
	protected function configure() {
		$this
		->setName('dutils:notifyTorrentDone')
		->setDescription('Triggers polling for torrents progress in Transmission and start of renaming and subtitles workers');
	}
	
	/**
	 * Notify torrent done - called from Transmission when a torrent finishes downloading
	 *
	 * @see \Symfony\Component\Console\Command\Command::execute()
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {
		$this->transmissionService->checkTorrentsStatus();
		$this->processManager->startRenamerWorker();
		$this->processManager->startSubtitleFetchWorker();
	}
	
}