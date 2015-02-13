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
	 * Fetch a torrent with the given hash or guid
	 * 
	 * @Route("/torrents/{hashOrGuid}")
     * @Method("GET")
	 * 
	 * @param unknown $hashOrGuid
	 */
	public function getTorrentAction($hashOrGuid) {
		
		try {

			$torrent = $this->torrentService->findTorrentByGuid($hashOrGuid);
			
			if ($torrent == null) {
				$torrent = $this->torrentService->findTorrentByHash($hashOrGuid);
			}
			
			if ($torrent != null) {
				return ControllerUtils::createJsonResponseForDto($this->serializer, $torrent);
			} else {
				return $this->generateErrorResponse("TORRENT_NOT_FOUND", 404);
			}
			
		} catch (\Exception $e)  {
			$this->logger->error("Error trying to get torrent " .$e->getTraceAsString());
			return $this->generateErrorResponse($e->getMessage(), 500);
		}
	} 
	
	
	/**
	 * Start download of the torrent represented for the specified magnet link or torrent file URI
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
	
	
	
	/**
	 *
	 * Check status of torrents currently in Transmission and update their state in database. Checked torrents
	 * are retrieved in the response
	 *
	 * @Route("/torrents/status")
	 * @Method("PUT")
	 *
	 */
	//TODO: add state parameter to exclude some states and some sorting; Add dateAdded, dateStarted, dateFinished to Torrent
	public function torrentsStatusAction(Request $request) {
		try {	
			$updatedTorrents = $this->transmissionService->checkTorrentsStatus();
			return ControllerUtils::createJsonResponseForDtoArray($this->serializer, $updatedTorrents, 200, "torrents");
		} catch(\Exception $e)  {
			return ControllerUtils::sendError("GENERAL_ERROR", $e->getMessage(), 500);
		}
	}
	
	/**
	 *
	 * Delete torrent from transmission and database
	 *
	 * @Route("/torrents/{hashOrGuid}")
	 * @Method("DELETE")
	 *
	 */
	public function deleteTorrentAction($hashOrGuid) {
		try {
			
			$torrent = $this->torrentService->findTorrentByGuid($hashOrGuid);
				
			if ($torrent == null) {
				$torrent = $this->torrentService->findTorrentByHash($hashOrGuid);
			}
				
			if ($torrent != null) {
				$this->torrentService->deleteTorrent($hashOrGuid, true);
				return ControllerUtils::createJsonResponseForArray(null);
			} else {
				return $this->generateErrorResponse("TORRENT_NOT_FOUND", 404);
			}
			
		} catch(\Exception $e)  {
			return ControllerUtils::sendError("GENERAL_ERROR", $e->getMessage(), 500);
		}
	}
	
	
	
	
	private function generateErrorResponse($message, $errorCode) {
		$error = array(
				"error" => "There was an error processing call: " . $message,
				"errorCode" => $errorCode);
			
		return ControllerUtils::createJsonResponseForArray($error, $errorCode);
	}	
}