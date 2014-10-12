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

/**
 * @Route("/api")
 */
class InstanceController extends Controller {
	
	/** @DI\Inject("instance.service") */
	private $instanceService;
	
	/** @DI\Inject("jms_serializer") */
	private $serializer;   
	
	/** @DI\Inject("torrentfeed.service") */
	private $torrentFeedService;
	
	/** @DI\Inject("logger") */
	private $logger;
	
	/** @DI\Inject("async.service") */
	private $asyncService;
	
	/**
	 * Get single Instance,
	 *
     * @Route("/instances/{id}")
     * @Method("GET")
	 *
	 */
	public function getInstanceAction($id) {
		$instance = $this->instanceService->find($id);
		
		$this->logger->info('This is a log message I put here');
		
		if (!$instance) {
			$error = array(
					"error" => "The required resource was not found",
					"errorCode" => 404);
			
			return ControllerUtils::createJsonResponseForArray($error, 404);	
		}
			
		//$this->torrentFeedService->checkFeedsForTorrents();
		$this->asyncService->test();
		
		return ControllerUtils::createJsonResponseForDto($this->serializer, $instance);
	}
	
	/**
	 * Create instance.
	 *
     * @Route("/instances")
     * @Method("POST")
     * 
     * @ParamConverter("instance", class="Entity\Instance", options={"json_property" = "instance"})
	 *
	 */
	public function postInstanceAction(Instance $instance) {
			
		if (!$instance->getId()) {
			$this->instanceService->persist($instance);
			return ControllerUtils::createJsonResponseForDto($this->serializer, $instance, 201);
		} else {
			return ControllerUtils::createJsonResponseForArray(array("error"=>"ID found, use PUT to update", "errorCode" => 405), 405);
		}
	}
	
}