<?php
namespace Morenware\DutilsBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Morenware\DutilsBundle\Form\InstanceType;
use Morenware\DutilsBundle\Entity\Instance;

/**
 * @Service("some.service.id")
 */
class InstanceService {

	private $em;
	
	private $formFactory;
	
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
	

	
}