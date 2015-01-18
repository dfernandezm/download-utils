<?php
namespace Morenware\DutilsBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Morenware\DutilsBundle\Form\InstanceType;
use Morenware\DutilsBundle\Entity\Instance;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\DiExtraBundle\Annotation\Service;

/** @Service("instance.service") */
class InstanceService {

	/** @DI\Inject("doctrine.orm.entity_manager") */
	public $em;
	
	private $repository;
	
	/** @DI\Inject("%morenware_dutils.instance.class%") */
	public $entityClass;
	
	public function __construct() {
		
	}
	
	public function getRepository() {
		
		if ($this->repository == null) {
			$this->repository = $this->em->getRepository($this->entityClass);
		}
		
		return $this->repository;
	}
	
	public function find($id) {
		return $this->getRepository()->find($id);
	}
	
	public function persist($instance) {
		$this->em->persist($instance);
		$this->em->flush($instance);
	}
	
	public function merge($instance) {
		$this->em->merge($instance);
		$this->em->flush($instance);
	}
	
	public function findAllNamed() {
		$query = $this->getRepository()->createNamedQuery("Instance.getAllNamed");
		return $query->getResult();
	}

	
}