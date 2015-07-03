<?php
namespace Morenware\DutilsBundle\Controller;

use Morenware\DutilsBundle\Entity\AutomatedSearchConfig;
use Morenware\DutilsBundle\Service\TorrentService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Morenware\DutilsBundle\Entity\Instance;
use Symfony\Component\HttpFoundation\Request;
use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Morenware\DutilsBundle\Util\ControllerUtils;
use Morenware\DutilsBundle\Entity\Torrent;


/**
 * @Route("/api")
 */
class AutomatedSearchApiController {
	
	/** @DI\Inject("jms_serializer") */
	private $serializer;   
	
	/** @DI\Inject("torrentfeed.service") */
	private $torrentFeedService;
	
	/** @DI\Inject("logger") */
	private $logger;

	/** @DI\Inject("processmanager.service") */
	public $processManager;
	
	/** @DI\Inject("automatedsearch.service")
     *  @var \Morenware\DutilsBundle\Service\AutomatedSearchService $automatedSearchService
     */
	public $automatedSearchService;


	/**
	 * Get automated search config by id
	 * 
	 * @Route("/automatedsearchs/{id}")
     * @Method("GET")
	 * 
	 * @param $id
	 */
	public function getAutomatedSearchAction($id) {
		
		try {

			$automatedSearch = $this->automatedSearchService->find($id);

			if ($automatedSearch != null) {
                $this->fillFeedIds($automatedSearch);
                return ControllerUtils::createJsonResponseForDto($this->serializer, $automatedSearch, 200, "automatedSearch");
			} else {
                return ControllerUtils::generateErrorResponse("AUTOMATED_SEARCH_NOT_FOUND", 404);
			}
			
		} catch (\Exception $e)  {
            return ControllerUtils::sendError("GENERAL_ERROR", $e->getMessage(), 500);
		}
	} 
	
	
	/**
	 * Creates a new automated search
	 *
     * @Route("/automatedsearchs")
     * @Method("POST")
	 *
	 * @ParamConverter("automatedSearch", class="Entity\AutomatedSearchConfig", options={"json_property" = "automatedSearch"})
	 */
	public function createAutomatedSearchAction(AutomatedSearchConfig $automatedSearch) {

       //TODO: validate!
       try {

           $this->automatedSearchService->create($automatedSearch);
           return ControllerUtils::createJsonResponseForDto($this->serializer, $automatedSearch, 200, "automatedSearch");

       } catch (\Exception $e) {
           return ControllerUtils::sendError("GENERAL_ERROR", $e->getMessage(), 500);
       }
	}

    /**
     * Updates existing automated search
     *
     * @Route("/automatedsearchs/{id}")
     * @Method("POST")
     *
     * @ParamConverter("automatedSearch", class="Entity\AutomatedSearchConfig", options={"json_property" = "automatedSearch"})
     */
    public function updateAutomatedSearchAction($id, AutomatedSearchConfig $automatedSearch) {

        //TODO: validate!

        try {

            $storedAutomatedSearch = $this->automatedSearchService->find($id);

            if ($storedAutomatedSearch != null) {
                $automatedSearch->setId($id);
                $this->automatedSearchService->update($automatedSearch);
                $automatedSearch = $this->automatedSearchService->find($id);
                return ControllerUtils::createJsonResponseForDto($this->serializer, $automatedSearch, 200, "automatedSearch");
            } else {
                return ControllerUtils::generateErrorResponse("AUTOMATED_SEARCH_NOT_FOUND", 404);
            }

        } catch (\Exception $e) {
            return ControllerUtils::sendError("GENERAL_ERROR", $e->getMessage(), 500);
        }
    }

    /**
     * List all automated searchs
     *
     * @Route("/automatedsearchs")
     * @Method("GET")
     *)
     */
    public function listAutomatedSearchsAction() {

        try {

            $automatedSearchs = $this->automatedSearchService->getAll();

            foreach ($automatedSearchs as $automatedSearch) {
                $this->fillFeedIds($automatedSearch);
            }

            return ControllerUtils::createJsonResponseForDtoArray($this->serializer, $automatedSearchs, 200, "automatedSearchs");

        } catch (\Exception $e) {
            return ControllerUtils::sendError("GENERAL_ERROR", $e->getMessage(), 500);
        }
    }
	

	/**
	 *
	 * Delete automated search
	 *
	 * @Route("/automatedsearchs/{id}")
	 * @Method("DELETE")
	 *
	 */
	public function deleteAutomatedSearchAction($id) {

        try {

            $automatedSearch = $this->automatedSearchService->find($id);

            if ($automatedSearch == null) {
                return ControllerUtils::generateErrorResponse("AUTOMATED_SEARCH_NOT_FOUND", 404);
			} else {
                $this->automatedSearchService->delete($automatedSearch);
                return ControllerUtils::createJsonResponseForArray(null);
            }

		} catch(\Exception $e)  {
			return ControllerUtils::sendError("GENERAL_ERROR", $e->getMessage(), 500);
		}
	}


    private function fillFeedIds($automatedSearch) {
        $feedIds = array();
        foreach($automatedSearch->getFeeds() as $feed) {

            $feedIds[] = $feed->getId();
        }

        $automatedSearch->setFeedIds($feedIds);

    }
}