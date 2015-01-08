<?php
namespace Morenware\DutilsBundle\Service;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\Common\Persistence\ObjectManager;
use Morenware\DutilsBundle\Entity\Torrent;
use Morenware\DutilsBundle\Entity\TorrentOrigin;
use Morenware\DutilsBundle\Entity\TorrentContentType;
use Morenware\DutilsBundle\Entity\TorrentState;
use Morenware\DutilsBundle\Entity\Feed;
use Morenware\DutilsBundle\Util\GuidGenerator;

/** @Service("torrent.service") */
class TorrentService {

	/** @DI\Inject("doctrine.orm.entity_manager") */
	public $em;
	
	private $repository;
	private $entityClass;
	private $logger;

   /**
	* @DI\InjectParams({
	*     "logger"           = @DI\Inject("logger"),
	*     "debrilFeedReader" = @DI\Inject("debril.reader"),
	*     "entityClass"      = @DI\Inject("%morenware_dutils.torrent.class%")
	* })
	*
	*/
	public function __construct($logger, $debrilFeedReader, $entityClass) {

		$this->logger = $logger;
		$this->entityClass = $entityClass;
	}
	
	public function getRepository() {
		
		if ($this->repository == null) {
			$this->repository = $this->em->getRepository($this->entityClass);
		}
		
		return $this->repository;
	}
	
	public function create($torrent) {
		$this->em->persist($torrent);
		$this->em->flush();
	}
	
	public function merge($torrent) {
		$this->em->merge($torrent);
		$this->em->flush();
	}
	
	public function find($id) {
		return $this->em->find($id);
	}	
	
	public function getAll() {
		return $this->repository->findAll();
	}
	
	public function delete($torrent) {
		$this->em->remove($torrent);
		$this->em->flush();
	}
	
	public function findTorrentByTransmissionId($transmissionId) {
		return $this->getRepository()->findOneBy(array('transmissionId' => $transmissionId));
	}
	
	
	public function updateDataForTorrents($torrentsResponse) {
		
		foreach ($torrentsResponse as $torrentResponse) {
			
			$percentDone = 100 * $torrentResponse->percentDone;
			$transmissionId = $torrentResponse->id;
			$torrentName = $torrentResponse->name;	
			
			$this->logger->debug("Checking if a torrent with transmission id  $transmissionId is already added");
			
			$existingTorrent = $this->findTorrentByTransmissionId($transmissionId);
			
			
			if ($existingTorrent != null) {
				
				$this->logger->debug("Torrent id $transmissionId found in DB, updating values -- percent is $percentDone, name is $torrentName");
				
				$existingTorrent->setPercentDone($percentDone);
				
				if ($percentDone == 100) {
					$this->logger->debug("Torrent name $torrentName download is completed");
					$existingTorrent->setState(TorrentState::DOWNLOAD_COMPLETED);
					// we could trigger here renaming for this torrent, but we will Transmission script for completions to notify the API launch renaming there
				} else {
					$existingTorrent->setState(TorrentState::DOWNLOADING);
				}
				
				$this->merge($existingTorrent);
				
			} else {
				$this->logger->debug("Torrent id $transmissionId not found in DB, creating now");
				$torrent = new Torrent();
				$torrent->setTransmissionId($transmissionId);
				$torrent->setGuid(GuidGenerator::generate());
				$torrent->setTorrentName($torrentName);
				$torrent->setState(TorrentState::DOWNLOADING);
				$torrent->setTitle($torrentName);
				
				// TODO: try to discover if it is movie or tv show using filebot??
				$torrent->setContentType(TorrentContentType::TV_SHOW);
				$torrent->setPercentDone($percentDone);
				$this->create($torrent);
			}
			
		}
	}
	
}