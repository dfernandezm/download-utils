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
        $this->logger->info("[FILEMANAGER] Received [" . $params->getPath() . "]");
        $files = $this->fileManagerService->listFiles($params->getPath());

//        $file1 = new FileInListing();
//        $file1->setDate("2015-04-29 09:04:24");
//        $file1->setName("First file");
//        $file1->setSize(4096);
//        $file1->setType("dir");
//        $file1->setRights("drwxrwxrwx");
//
//        $files[] = $file1;




        return ControllerUtils::createJsonResponseForDtoArray($this->serializer, $files, 200, "result");
    }


}