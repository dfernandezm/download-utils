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
use Morenware\DutilsBundle\Util\GuidGenerator;
use Morenware\DutilsBundle\Entity\JobState;
use Morenware\DutilsBundle\Entity\Feed;

/**
 * @Route("/api")
 */
class TorrentFeedController {
	
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
	

	
	/**
	 * Get feed by id
	 *
     * @Route("/feeds/{id}")
     * @Method("GET")
	 *
	 */
	public function getFeedAction($id) {
		
		$feed = $this->torrentFeedService->find($id);		
		
		if (!$feed) {
			$error = array(
					"error" => "The required resource was not found",
					"errorCode" => 404);
			
			return ControllerUtils::createJsonResponseForArray($error, 404);	
		}
		
		return ControllerUtils::createJsonResponseForDto($this->serializer, $feed);
	}
	
	/**
	 * Create new feed.
	 *
     * @Route("/feeds")
     * @Method("POST")
     * 
     * @ParamConverter("feed", class="Entity\Feed", options={"json_property" = "feed"})
	 *
	 */
	public function createFeedPostAction(Feed $feed) {
			
		if (!$feed->getId()) {
			$this->torrentFeedService->create($feed);
			return ControllerUtils::createJsonResponseForDto($this->serializer, $feed, 201);
		} else {
			return $this->updateFeedAction($feed->getId(), $feed);
		}
	}
	
	/**
	 * Update a feed.
	 *
	 * @Route("/feeds/{id}")
	 * @Method("PUT")
	 *
	 * @ParamConverter("feed", class="Entity\Feed", options={"json_property" = "feed"})
	 *
	 */
	public function updateFeedAction($id, Feed $feed) {
			
		if ($id) {
			$feed->setId($id);
			$this->torrentFeedService->update($feed);
			return ControllerUtils::createJsonResponseForDto($this->serializer, $feed, 200);
		} else {
			return $this->createFeedPostAction($feed);
		}
	}
	
	/**
	 * Delete feed with the given id.
	 *
	 * @Route("/feeds/{id}")
	 * @Method("DELETE")
	 *
	 */
	public function deleteFeedAction($feedId) {
		$this->torrentFeedService->delete($feedId);
		return ControllerUtils::createJsonResponseForArray(null);
	}
	
	/**
	 * List all feeds.
	 *
	 * @Route("/feeds")
	 * @Method("GET")
	 *
	 *
	 */
	public function listFeedsAction() {
		
		return ControllerUtils::createJsonResponseForDto($this->serializer, $this->torrentFeedService->getAll());
	}
	
	/**
	 * Check the active feeds for new torrents. If torrents are found they are created in the system pending to download and
	 * queued in Transmission.
	 * 
	 * @Route("/feedscheck")
	 * @Method("GET")
	 * 
	 */
	public function checkFeedsAction() {
	
		try {
			$this->torrentFeedService->checkFeedsForTorrents();
			return ControllerUtils::createJsonResponseForArray(null);
		} catch(\Exception $e)  {
			$error = array(
					"error" => "There was an error checking feeds ".$e->getMessage(),
					"errorCode" => 500);
				
			return ControllerUtils::createJsonResponseForArray($error, 500);
		}

	}
	
	/**
	 * TODO: Move to another API endpoint
	 * 
	 * Check status of downloading torrents
	 *
	 * @Route("/torrents/check")
	 * @Method("GET")
	 *
	 */
	public function checkTorrentsAction() {
	
		try {
			$this->transmissionService->checkTorrentsStatus();
			return ControllerUtils::createJsonResponseForArray(null);
		} catch(\Exception $e)  {
			$error = array(
					"error" => "There was an error checking torrents ".$e->getMessage(),
					"errorCode" => 500);
	
			return ControllerUtils::createJsonResponseForArray($error, 500);
		}
	
	}
	
	/**
	 * TODO: Move to another API endpoint
	 *
	 * Check status of downloading torrents every 10 seconds
	 *
	 * @Route("/torrents/checkdaemon")
	 * @Method("GET")
	 *
	 */
	public function checkTorrentsContinuouslyAction() {
	
		try {
			$this->processManager->startDownloadsMonitoring();
			return ControllerUtils::createJsonResponseForArray(null);
		} catch(\Exception $e)  {
			$error = array(
					"error" => "There was an error checking torrents ".$e->getMessage(),
					"errorCode" => 500);
	
			return ControllerUtils::createJsonResponseForArray($error, 500);
		}
	
	}
	
	
}