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
			$this->torrentFeedService->merge($feed);
			return ControllerUtils::createJsonResponseForDto($this->serializer, $feed, 200);
		} else {
			return $this->createFeedPostAction($feed);
		}
	}
	
	/**
	 * Delete feed.
	 *
	 * @Route("/feeds/{id}")
	 * @Method("DELETE")
	 *
	 * @ParamConverter("feed", class="Entity\Feed", options={"json_property" = "feed"})
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
	 * Check feeds
	 * 
	 * @Route("/checkfeeds")
	 * @Method("GET")
	 * 
	 */
	public function checkFeedsAction() {
	
		try {
			$this->torrentFeedService->checkFeedsForTorrents();
			return ControllerUtils::createJsonResponseForArray(null);
		} catch(\Exception $e)  {
			$error = array(
					"error" => "There was an error executing ".$e->getMessage(),
					"errorCode" => 500);
				
			return ControllerUtils::createJsonResponseForArray($error, 500);
		}
	}
	
	
	
	
}