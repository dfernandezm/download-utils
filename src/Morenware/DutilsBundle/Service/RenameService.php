<?php
namespace Morenware\DutilsBundle\Service;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;
use Morenware\DutilsBundle\Util\GuidGenerator;

/** @Service("rename.service") */
class RenameService {
	
	private $renamerLogger;
		
	/** @DI\Inject("torrent.service") */
	public $torrentService;
	
	/** @DI\Inject("transmission.service") */
	public $transmissionService;
	
	/** @DI\Inject("processmanager.service") */
	public $processManager;
	
	/** @DI\Inject("kernel") */
	public $kernel;

	/** @DI\Inject("settings.service") */
	public $settingsService;
	
	// The script
	const SUBTITLES_SCRIPT_PATH = "scripts/multiple-subtitle-filebot.sh";
    
   
   /**
	* @DI\InjectParams({
	*     "logger" = @DI\Inject("monolog.logger.renamer")
	* })
	*
	*/
	public function __construct($logger) {

		$this->renamerLogger = $logger;
	}
	
	
	public function renameDownloadCompletedTorrents() {
		//TODO:
	}
}