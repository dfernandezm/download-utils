<?php
namespace Morenware\DutilsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Morenware\DutilsBundle\Util\ControllerUtils;
use Morenware\DutilsBundle\Entity\Torrent;

/**
 * This controller is used to receive (push) notifications from external services
 * 
 * @Route("/api")
 */
class NotifyController {
	
	/** @DI\Inject("transmission.service") */
	public $transmissionService;
	
	/** @DI\Inject("torrent.service") */
	public $torrentService;
	
	/** @DI\Inject("processmanager.service") */
	public $processManager;
	
	/** @DI\Inject("logger") */
	private $logger;
	
	
	/**
	 * Notification from transmission that a download has finished. This will trigger a single
	 * poll for status in transmission and only a subset of torrents will be updated and renamed.
	 *
     * @Route("/notify/finished")
     * @Method("PUT")
     * 
	 */
	public function putTransmissionNotificationAction() {			
		try {
			
			$this->transmissionService->checkTorrentsStatus();
			$this->processManager->startRenamerWorker();
			$this->processManager->startSubtitleFetchWorker();
			return ControllerUtils::createJsonResponseForArray(null);
		} catch (\Exception $e) {
			$this->logger->error("Error notifying from transmission " . $e->getMessage() . " " . $e->getTraceAsString());
			$error = array(
					"error" => "There was an error notifying from transmission ".$e->getMessage(),
					"errorCode" => 500);
			
			return ControllerUtils::createJsonResponseForArray($error, 500);
		}
	}
}