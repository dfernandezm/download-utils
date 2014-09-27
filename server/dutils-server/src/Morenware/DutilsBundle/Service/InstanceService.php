<?php
namespace Morenware\DutilsBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Morenware\DutilsBundle\Form\InstanceType;
use Morenware\DutilsBundle\Entity\Instance;
use JMS\DiExtraBundle\Annotation as DI;

class InstanceService {

	private $em;
	
	private $repository;
	
	public function __construct(ObjectManager $em, $entityClass) {
		$this->em = $em;
		$this->entityClass = $entityClass;
		$this->repository = $this->em->getRepository($this->entityClass);
	}
	
	public function find($id) {
		return $this->repository->find($id);
	}
	
	public function persist($instance) {
		$this->em->persist($instance);
		$this->em->flush($instance);
	}
	
	public function merge($instance) {
		$this->em->merge($instance);
		$this->em->flush($instance);
	}

	
}