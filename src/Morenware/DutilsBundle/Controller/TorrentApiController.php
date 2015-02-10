<?php
namespace Morenware\DutilsBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Morenware\DutilsBundle\Entity\Instance;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Morenware\DutilsBundle\Util\ControllerUtils;
use Morenware\DutilsBundle\Entity\Torrent;


/**
 * @Route("/api")
 */
class TorrentApiController {
	
	/** @DI\Inject("jms_serializer") */
	private $serializer;   
	
	/** @DI\Inject("torrentfeed.service") */
	private $torrentFeedService;
	
	/** @DI\Inject("logger") */
	private $logger;
	
	/** @DI\Inject("transmission.service") */
	public $transmissionService;
	
	/** @DI\Inject("processmanager.service") */
	public $processManager;
	
	/** @DI\Inject("torrent.service") */
	public $torrentService;

	
	/**
	 * Start download of the torrent reprensented for the specified magnet link or torrent file URI
	 *
     * @Route("/torrents")
     * @Method("POST")
	 *
	 * @ParamConverter("torrent", class="Entity\Torrent", options={"json_property" = "torrent"})
	 */
	public function downloadTorrentAction(Torrent $torrent) {
		
		try {
			$this->logger->debug("Torrent is " . $torrent->getMagnetLink());
			if ($torrent->getMagnetLink() != null) {
				$torrent = $this->torrentService->startDownloadFromMagnetLink($torrent->getMagnetLink());
			} else if ($torrent->getFilePath() != null) {
				$torrent = $this->torrentService->startDownloadFromTorrentFile($torrent->getFilePath());
			} else {
				return $this->generateErrorResponse("INVALID_TORRENT", 400);
			}
			
			return ControllerUtils::createJsonResponseForDto($this->serializer, $torrent);
			
		} catch (\Exception $e) {
			$this->logger->error("Error: " . str_replace("#", "\n#", $e->getTraceAsString()));	
			return $this->generateErrorResponse($e->getMessage(), 400);
		}
	}
	
	
	private function generateErrorResponse($message, $errorCode) {
		$error = array(
				"error" => "There was an error processing call: " . $message,
				"errorCode" => $errorCode);
			
		return ControllerUtils::createJsonResponseForArray($error, $errorCode);
	}	
}