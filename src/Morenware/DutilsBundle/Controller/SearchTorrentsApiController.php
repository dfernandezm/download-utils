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
class SearchTorrentsApiController extends Controller {
	
	/** @DI\Inject("jms_serializer") */
	private $serializer;   
	
	/** @DI\Inject("logger") */
	private $logger;
	
	/** @DI\Inject("search.service") */
	private $searchService;
	
	
	/**
	 * Search the given query
	 *
     * @Route("/search")
     * @Method("GET")
	 *
	 */
	public function searchQueryAction(Request $request) {
		
		$searchQuery = $request->query->get("searchQuery", null);
		$sitesParam = $request->query->get("sitesParam", null);
		$websitesToSearch = array();
		$this->logger->debug('Sites is  '. $sitesParam);
		
		if ($sitesParam !== null) {
			$websitesToSearch = explode(",",$sitesParam);
		}
		
		$this->logger->debug('Received query to search: '. $searchQuery . " websites is: " . print_r($websitesToSearch,true));
		
		list($torrents, $currentOffset, $total) = $this->searchService->searchTorrentsInWebsites($searchQuery, $websitesToSearch, 25, 0);    		

		$this->logger->debug('Torrents are: ' . print_r($torrents,true));
		
    	$torrentsInfo =
    				array('torrents' => $torrents, 
    					  'limit' => 25,
    					  'offset' => 0,		 
    					  'currentOffset' => $currentOffset, 
    					  'total' => $total,  
    					  'query' => $searchQuery
    				);
		
    	return ControllerUtils::createJsonResponseForDtoArray($this->serializer, $torrentsInfo, 200, "torrentsInfo");
	}	
}