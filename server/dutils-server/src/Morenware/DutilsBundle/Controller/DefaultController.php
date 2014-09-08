<?php

namespace Morenware\DutilsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
	/**
	 * Create instance.
	 *
	 * @Route("/home")
	 * @Method("GET")
	 *
	 */
	public function indexAction()
    {
        return $this->render('MorenwareDutilsBundle:Default:index.html.twig');
    }
}
