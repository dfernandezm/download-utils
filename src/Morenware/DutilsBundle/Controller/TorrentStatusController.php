<?php

namespace Morenware\DutilsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;
use Morenware\DutilsBundle\Util\ControllerUtils;

class TorrentStatusController extends Controller
{

	/** @DI\Inject("torrent.service") */
	private $torrentService;

	/** @DI\Inject("logger") */
	private $logger;

	/** @DI\Inject("jms_serializer") */
	private $serializer;


    /**
     * Torrents status page, server page shown from initial call
     *
     * @Route("/status")
     * @Method("GET")
     *
     */
    public function torrentStatusAction(Request $request) {

			//$torrents = $this->torrentService->findTorrentsByState("COMPLETED");
			$torrents = $this->torrentService->getAllOrderedByDate();
			$torrentsJson = ControllerUtils::createJsonStringForDto($this->serializer,
					array('torrents' => $torrents
			));

			$this->logger->debug("STATUS == torrents json is ". $torrentsJson);

    	return $this->render('MorenwareDutilsBundle:Default:torrentsStatus.html.twig', array('torrents' => $torrentsJson));

    }
}
