<?php

namespace Morenware\DutilsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;
use Morenware\DutilsBundle\Util\ControllerUtils;

class DefaultController extends Controller
{
	
	/** @DI\Inject("search.service") */
	private $searchService;
	
	/** @DI\Inject("logger") */
	private $logger;
	
	/** @DI\Inject("jms_serializer") */
	private $serializer;
	
	
	/**
	 * Home.
	 *
	 * @Route("/home")
	 * @Method("GET")
	 *
	 */
	public function indexAction()
    {
        return $this->render('MorenwareDutilsBundle:Default:index.html.twig');
    }
    
    /**
     * Feeds.
     *
     * @Route("/feeds")
     * @Method("GET")
     *
     */
    public function feedsAction()
    {
    	return $this->render('MorenwareDutilsBundle:Default:feeds.html.twig');
    }
    
    /**
     * Search torrents page, server page shown from initial call
     *
     * @Route("/search")
     * @Method("GET")
     *
     */
    public function searchAction(Request $request) {
    	$searchQuery = $request->query->get("searchQuery", null);
    	$limit = $request->query->get("limit", 25);
    	$offset = $request->query->get("offset", 0);
    	
    	if ($searchQuery !== null) {
    		
    		$limit = 25;
    		$offset = 25;
    		
    		list($torrents, $currentOffset, $total) = $this->searchService->searchTorrentsInWebsites($searchQuery, $limit, $offset);
    		
    		$torrentsJson = ControllerUtils::createJsonStringForDto($this->serializer, $torrents);
    		
    		
    		$torrentsInfoJson = ControllerUtils::createJsonStringForDto($this->serializer, 
    				array('torrents' => $torrents, 
    					  'limit' => $limit,
    					  'offset' => $offset,		 
    					  'currentOffset' => $currentOffset, 
    					  'total' => $total,  
    					  'query' => $searchQuery
    				));
    		
			
    		$this->logger->debug("TORRENTS JSON ALL: $torrentsInfoJson");
    		
    		return $this->render('MorenwareDutilsBundle:Default:search.html.twig', array('torrentsInfo' => $torrentsInfoJson));
    						
    	} else {
    		return $this->render('MorenwareDutilsBundle:Default:search.html.twig', array('torrentsInfo' => 'null'));
    	}
    	
    	
    	
    }
}
