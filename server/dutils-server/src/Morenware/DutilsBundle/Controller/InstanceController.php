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

/**
 * @Route("/api")
 */
class InstanceController {
	
	/** @DI\Inject("instance.service") */
	private $instanceService;
	
	/** @DI\Inject("jms_serializer") */
	private $serializer;
	
	/** @DI\Inject("torrent.feed.service") */
	private $torrentService;
	
	
	/**
	 * Get single Instance,
	 *
     * @Route("/instances/{id}")
     * @Method("GET")
	 *
	 */
	public function getInstanceAction($id) {
		$instance = $this->instanceService->find($id);
	
		if (!$instance) {
			$error = array(
					"error" => "The required resource was not found",
					"errorCode" => 404);
			
			return $this->createJsonResponseWithArray($error, 404);	
		}
		
		return $this->createJsonResponseWithDto($instance);
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
			return $this->createJsonResponseWithDto($instance, 201);
		} else {

			return $this->createJsonResponseWithArray(array("error"=>"ID found, use PUT to update", "errorCode" => 405), 405);
		}
	}
	
	
	
	private function createJsonResponseWithDto($object, $statusCode = 200) {
		$data = json_decode($this->serializer->serialize($object, 'json'));
		return new JsonResponse($data, $statusCode);
	}
	
	private function createJsonResponseWithArray($array, $statusCode = 200) {
		return new JsonResponse($array, $statusCode);
	}
	
}