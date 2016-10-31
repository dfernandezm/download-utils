<?php

namespace Morenware\DutilsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;
use Morenware\DutilsBundle\Util\ControllerUtils;

class FileManagerController extends Controller
{

	/**
	 * Home.
	 *
	 * @Route("/filemanager")
	 * @Method("GET")
	 *
	 */
	public function fileManagerAction()
    {
        return $this->render('MorenwareDutilsBundle:Filemanager:filemanager.html.twig');
    }

}
