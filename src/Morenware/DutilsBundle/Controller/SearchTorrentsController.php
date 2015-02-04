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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Morenware\DutilsBundle\Service\WorkerType;
use Morenware\DutilsBundle\Entity\Torrent;

/**
 * @Route("/api")
 */
class SearchTorrentsController extends Controller {
	
	/** @DI\Inject("jms_serializer") */
	private $serializer;   
	
	/** @DI\Inject("logger") */
	private $logger;
	
	/** @DI\Inject("search.service") */
	private $searchService;
	
	
	/**
	 * Get single Instance,
	 *
     * @Route("/search")
     * @Method("GET")
	 *
	 */
	public function searchQueryAction(Request $request) {
		
		$searchQuery = $request->query->get("searchQuery", null);
		$ip = $request->get('request')->getClientIp();
		
		$this->logger->debug('Received query to search: '. $searchQuery . " from IP ". $ip);
		
		$torrents = $this->searchService->searchTorrentsInWebsites($searchQuery);
		
		return ControllerUtils::createJsonResponseForDto($this->serializer, $torrents);
	}
	
	/**
	 * Create instance.
	 *
	 * @Route("/search/torrent/get")
	 * @Method("GET")
	 *
	 */
	public function downloadTorrentFileOnDemandAction(Request $request) {
		$fileLink = $request->query->get("torrentLink", null);
		$torrentName = $request->query->get("name", null);
		
		if ($fileLink != null) {
			//$torrentFile = file_get_contents($fileLink);
			
			// Generate response
			$response = new Response();
			
			// Set headers
			$response->headers->set('Cache-Control', 'private');
			$response->headers->set('Content-type', mime_content_type($torrentName));
			$response->headers->set('Content-Disposition', 'attachment; filename="' . basename($torrentName) . '";');
			$response->headers->set('Content-length', filesize($torrentName));
			
			// Send headers before outputting anything
			$response->sendHeaders();
			
			$response->setContent(readfile($fileLink));
			
		}
	}
	
	/**
	 * Create instance.
	 *
     * @Route("/search/torrent/addfile")
     * @Method("POST")
     * 
     * @ParamConverter("torrent", class="Entity\Torrent", options={"json_property" = "torrent"})
	 *
	 */
	public function addTorrentAction(Torrent $torrent) {
			

	}
	
	/**
	 * Create instance.
	 *
	 * @Route("/torrent/download")
	 * @Method("POST")
	 *
     * @ParamConverter("torrent", class="Entity\Torrent", options={"json_property" = "torrent"})
	 *
	 */
	public function downloadTorrentAction(Torrent $torrent) {
		$this->searchService->downloadTorrentToFileAndStart($torrent);
		return ControllerUtils::createJsonResponseForArray(null);
	}
		
		
}