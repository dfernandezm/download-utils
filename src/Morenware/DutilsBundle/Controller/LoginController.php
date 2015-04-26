<?php

namespace Morenware\DutilsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;
use Morenware\DutilsBundle\Util\ControllerUtils;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginController extends Controller
{

	/** @DI\Inject("logger") */
	private $logger;

	
	/**
	 *
	 * @Route("/login", name="login")
	 *
	 */
	public function loginAction() {
		$authenticationUtils = $this->get('security.authentication_utils');
		
		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();
		
		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();
		
		return $this->render(
				'MorenwareDutilsBundle:Default:login.html.twig',
				array(
						// last username entered by the user
						'last_username' => $lastUsername,
						'error'         => $error,
				)
		);
    }
    
   /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        // this controller will not be executed
        // 
        //return new JsonResponse();
    }
    
}
