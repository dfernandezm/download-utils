<?php
namespace Morenware\DutilsBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
class InstanceController extends FOSRestController {
	
	public function getPageAction($id)
	{
		return $this->container->get('doctrine.entity_manager')->getRepository('Instance')->find($id);
	}
	
}