<?php
namespace Morenware\DutilsBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Morenware\DutilsBundle\Entity\Instance;
use Morenware\DutilsBundle\Form\InstanceType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use JMS\DiExtraBundle\Annotation as DI;
class InstanceController extends FOSRestController {
	
	/** @DI\Inject("morenware_dutils.instance.service") */
	private $instanceService;
	
	/** @DI\Inject("fos_rest.view_handler") */
	private $fosRestViewHandler;
	
	/**
	 * Get single Instance,
	 *
	 *
	 * @Annotations\View(templateVar="instance")
	 *
	 * @param Request $request the request object
	 * @param int     $id      the page id
	 *
	 * @return array
	 *
	 * @throws NotFoundHttpException when page not exist
	 */
	public function getInstanceAction($id)
	{
		$instance = $this->instanceService->find($id);
	
		if (!$instance) {
			throw new NotFoundHttpException(sprintf('The resource %s was not found',$id));
		}
		
 		$view = View::create()
 		->setStatusCode(200)
 		->setData($instance)
 		->setFormat('json');

		return $this->fosRestViewHandler->handle($view);
	}
	
	/*
	* @Annotations\View(
	*  statusCode = Codes::HTTP_BAD_REQUEST,
	*  templateVar = "instanceForm"
	* )
	*
	* @param Request $request the request object
	*
	* @return FormTypeInterface|View
	*/
	public function postInstanceAction(Request $request)
	{
		try {
			$params = $request->request->all();
			$newInstance = $this->handlePost($params);
			
			
			if (is_array($newInstance)) {
				//BAD Request
				return null;
			} else {
				$view = View::create()
				->setStatusCode(200)
				->setData($newInstance)
				->setFormat('json');
				
				return $this->get('fos_rest.view_handler')->handle($view);
			}
			
	
		} catch (InvalidFormException $exception) {

			return $exception->getForm();
		}
	}

	
    function handlePost(array $parameters) {
		$instance = new Instance();
		return $this->processForm($instance, $parameters, 'POST');
		
	}
	
	
	private function processForm(Instance $instance, array $parameters, $method = "POST") {
		$formFactory = $this->container->get('form.factory');
		$instanceService = $this->container->get('morenware_dutils.instance.service');
		$form = $formFactory->create(new InstanceType(), $instance, array('method' => $method));
		$form->submit($parameters, 'PATCH' !== $method);
		if ($form->isValid()) {
	
			$instance = $form->getData();
			$instanceService->persist($instance);
	
			return $instance;
		}
	
		return array('result'=>false, 'form'=>$form);
	}
	
	
	
}