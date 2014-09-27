<?php
namespace Morenware\DutilsBundle\Service;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\Common\Persistence\ObjectManager;

class TorrentFeedService {

	private $em;
	
	private $repository;
	
	/** @DI\Inject("logger") */
	public $logger;
	
	
	public function __construct(ObjectManager $em, $entityClass) {
		$this->em = $em;
		$this->entityClass = $entityClass;
		$this->repository = $this->em->getRepository($this->entityClass);
	}
	
	public function createFeed($feed) {
		$this->em->persist($feed);
		$this->em->flush($feed);
	}
	
	public function mergeFeed($feed) {
		$this->em->merge($feed);
		$this->em->flush($feed);
	}
	
	public function findFeed($id) {
		return $this->em->find($id);
	}	
	
	public function getAllFeeds() {
		return $this->repository->findAll();
	}

	
	public function checkFeedsForTorrents() {

		// list all feeds
		// marshall to objects
		// check dates
		
		
		
	}
	
	
	
	
	
	
}