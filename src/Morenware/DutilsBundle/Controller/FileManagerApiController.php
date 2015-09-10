<?php
/**
 * User: david
 * Date: 31/08/2015
 * Time: 21:53
 */

namespace Morenware\DutilsBundle\Controller;

use JMS\DiExtraBundle\Annotation as DI;
use Morenware\DutilsBundle\Entity\FileInListing;
use Morenware\DutilsBundle\Entity\FileManagerRequestParams;
use Morenware\DutilsBundle\Util\ControllerUtils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


/**
 * @Route("/api")
 */
class FileManagerApiController extends Controller {

    /** @DI\Inject("jms_serializer") */
    private $serializer;

    /** @DI\Inject("logger") */
    private $logger;

    /** @DI\Inject("filemanager.service") */
    private $fileManagerService;

    /**
     * @Route("/media/list")
     * @Method("POST")
     *
     * @param FileManagerRequestParams $params
     * @return JsonResponse
     *
     * @ParamConverter("params", class="Entity\FileManagerRequestParams", options={"json_property" = "params"})
     */
    public function listAction(FileManagerRequestParams $params) {
        $this->logger->info("[FILEMANAGER-LIST] Received [" . $params->getPath() . "]");
        $files = $this->fileManagerService->listFiles($params->getPath());
        return ControllerUtils::createJsonResponseForDtoArray($this->serializer, $files, 200, "result");
    }

    /**
     * @Route("/media/rename")
     * @Method("POST")
     *
     * @param FileManagerRequestParams $params
     * @return JsonResponse
     *
     * @ParamConverter("params", class="Entity\FileManagerRequestParams", options={"json_property" = "params"})
     */
    public function renameAction(FileManagerRequestParams $params) {
        $this->logger->info("[FILEMANAGER-RENAME] Received [" . $params->getPath() . " => " . $params->getNewPath() ." ]");

        try {

            $this->fileManagerService->renameOrMove($params->getPath(), $params->getNewPath());

            $result = array(
                "success" => true,
                "error" => null
            );

            return ControllerUtils::createJsonResponseForDtoArray($this->serializer, $result, 200, "result");

        }  catch (\Exception $e)  {
            $this->logger->error("Error renaming " . $e->getTraceAsString());
            $result = array(
                "success" => false,
                "error" => "Error renaming " . $params->getNewPath());

            return ControllerUtils::createJsonResponseForDtoArray($this->serializer, $result, 500, "result");
        }
    }

    /**
     * @Route("/media/remove")
     * @Method("POST")
     *
     * @param FileManagerRequestParams $params
     * @return JsonResponse
     *
     * @ParamConverter("params", class="Entity\FileManagerRequestParams", options={"json_property" = "params"})
     */
    public function removeAction(FileManagerRequestParams $params) {
        $this->logger->info("[FILEMANAGER-REMOVE] Received [ " . $params->getPath() ." ]");

        try {

            $this->fileManagerService->remove($params->getPath());

            $result = array(
                "success" => true,
                "error" => null
            );

            return ControllerUtils::createJsonResponseForDtoArray($this->serializer, $result, 200, "result");

        }  catch (\Exception $e)  {
            $this->logger->error("Error deleting " . $e->getTraceAsString());
            $result = array(
                "success" => false,
                "error" => "Error deleting " . $params->getPath());

            return ControllerUtils::createJsonResponseForDtoArray($this->serializer, $result, 500, "result");
        }
    }


    /**
    * @Route("/media/content")
    * @Method("POST")
    *
    * @param FileManagerRequestParams $params
    * @return JsonResponse
    *
    * @ParamConverter("params", class="Entity\FileManagerRequestParams", options={"json_property" = "params"})
    */
    public function getContentAction(FileManagerRequestParams $params) {
        $this->logger->info("[FILEMANAGER-GET-CONTENT] Received [ " . $params->getPath() ." ]");

        try {

            $content = $this->fileManagerService->getSubtitleContent($params->getPath());

            $result = $content;

            return ControllerUtils::createJsonResponseForDtoArray($this->serializer, $result, 200, "result");

        }  catch (\Exception $e)  {
            $this->logger->error("Error getting content " . $e->getTraceAsString());
            $result = array(
                "success" => false,
                "error" => "Error getting content " . $params->getPath());

            return ControllerUtils::createJsonResponseForDtoArray($this->serializer, $result, 500, "result");
        }
    }

    /**
     * @Route("/media/edit")
     * @Method("POST")
     *
     * @param FileManagerRequestParams $params
     * @return JsonResponse
     *
     * @ParamConverter("params", class="Entity\FileManagerRequestParams", options={"json_property" = "params"})
     */
    public function editAction(FileManagerRequestParams $params) {
        $this->logger->info("[FILEMANAGER-GET-EDIT] Received [ " . $params->getPath() ." ]");

        try {

            $this->fileManagerService->editSubtitle($params->getContent(), $params->getPath());

            $result = array(
                "success" => true,
                "error" => null
            );

            return ControllerUtils::createJsonResponseForDtoArray($this->serializer, $result, 200, "result");

        }  catch (\Exception $e)  {
            $this->logger->error("Error editing " . $e->getTraceAsString());
            $result = array(
                "success" => false,
                "error" => "Error editing " . $params->getPath());

            return ControllerUtils::createJsonResponseForDtoArray($this->serializer, $result, 500, "result");
        }
    }
}