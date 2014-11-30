<?php

namespace Morenware\DutilsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
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
