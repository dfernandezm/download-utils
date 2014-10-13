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

/**
 * This controller is used to receive (push) notifications from external services
 * 
 * @Route("/api")
 */
class NotifyController extends Controller {
	
	/** @DI\Inject("async.service") */
	private $asyncService;
	
	/** @DI\Inject("torrentfeed.service") */
	private $torrentFeedService;
	
	
	/**
	 * Notifies something is ready in the responses queue
	 *
     * @Route("/notify")
     * @Method("POST")
     * 
	 */
	public function postNotificationAction() {			
		$this->asyncService->pollResponsesQueue();
		return ControllerUtils::createJsonResponseForArray(null);
	}
	
	
	/**
	 * Feed checker externally invoked
	 *
	 * @Route("/notify/checkFeeds")
	 * @Method("POST")
	 *
	 */
	public function postCheckFeeds() {
		$this->torrentFeedService->checkFeedsForTorrents();
		return ControllerUtils::createJsonResponseForArray(null);
	}
}