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
    
}
