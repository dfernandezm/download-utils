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
	
	/** @DI\Inject("processmanager.service") */
	public $processManager;
	
	/** @DI\Inject("transmission.service") */
	public $transmissionService;
	
	
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
	
	public function persist($torrent) {
		$this->em->persist($torrent);
	}
	
	public function merge($torrent) {
		$this->em->merge($torrent);
		//TODO: remove, as this commits automatically and this method is intended to be called inside a transactional block
		$this->em->flush();
	}
	
	public function update($torrent) {
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
	
	public function findTorrentByHash($torrentHash) {
		return $this->getRepository()->findOneBy(array('hash' => $torrentHash));
	}
	
	
	public function updateDataForTorrents($torrentsResponse) {
		
		foreach ($torrentsResponse as $torrentResponse) {
			
			$percentDone = 100 * $torrentResponse->percentDone;
			$transmissionId = $torrentResponse->id;
			$torrentName = $torrentResponse->name;
			$torrentHash = $torrentResponse->hashString;	
			
			$this->logger->debug("Checking if a torrent with transmission id  $transmissionId and hash $torrentHash is already added");
			
			$existingTorrent = $this->findTorrentByTransmissionId($transmissionId);
			
			
			if ($existingTorrent != null) {
				
				$torrentState = $existingTorrent->getState();
				$this->logger->debug("Torrent id $transmissionId found in DB, updating values -- percent is $percentDone, name is $torrentName, state is $torrentState");
				
				$existingTorrent->setPercentDone($percentDone);
				$existingTorrent->setHash($torrentHash);
				
				$this->logger->debug("The Percent done is $percentDone and status is $torrentState ");
					
				if ($percentDone != null && $percentDone > 0 && $percentDone < 100) {
					$existingTorrent->setState(TorrentState::DOWNLOADING);
				} else if ($percentDone == 100 && $torrentState == TorrentState::DOWNLOADING) {
					$this->logger->debug("Torrent name $torrentName download is completed");
					$existingTorrent->setState(TorrentState::DOWNLOAD_COMPLETED);
				}
				
				$this->merge($existingTorrent);
				
			} else {
				$this->logger->debug("Torrent id $transmissionId not found in DB, creating and relocating now");
				
				// Relocate the torrent to the known subfolder as we are creating it now
				$this->transmissionService->relocateTorrent($transmissionId, $torrentName, $torrentHash);
				
				$torrent = new Torrent();
				$torrent->setTransmissionId($transmissionId);
				$torrent->setGuid(GuidGenerator::generate());
				$torrent->setTorrentName($torrentName);
				$torrent->setState(TorrentState::DOWNLOADING);
				$torrent->setTitle($torrentName);
				$torrent->setHash($torrentHash);
				
				// TODO: try to discover if it is movie or tv show using filebot here??
				$torrent->setContentType(TorrentContentType::TV_SHOW);
				$torrent->setPercentDone($percentDone);
				$this->create($torrent);
			}	
		}
	}
	
	//TODO: we can use a subfolder (known) for each torrent when adding it and it would be easier to do this!
	// For torrent added outside of here, we can rename/relocate it with a JSON RPC method
	
	/**
	 * Looks up in the renamer log file matching paths of renaming to identify torrents by its name
	 * 
	 * @param unknown $renamerLogFilePath
	 */
	public function processTorrentsAfterRenaming($renamerLogFilePath) {
		
		$this->logger->info("[RENAMING] Starting state update of torrents after renaming");
		
		$pathMovedPattern = '/\[MOVE\]\s+Rename\s+(.*)to\s+\[(.*)\]/';
		$logContent = file_get_contents($renamerLogFilePath);
		
		$matches = array();
		
		if (preg_match_all($pathMovedPattern, $logContent, $matches)) {
		
			$originalPathList = $matches[1];
			$newPathList = $matches[2];
			
			for ($i = 0; $i < count($originalPathList); $i++) {
				
				$originalPath = $originalPathList[$i];
				$newPath = $newPathList[$i];
				
				$this->logger->debug("[RENAMING] Detected renamed path:  $originalPath ===> $newPath");
				
				// $newPath.endsWith(".srt")
				if (strrpos($newPath, ".srt", strlen($newPath) - strlen(".srt")) !== false) {
					// This is a subtitle, move on
					continue;
				}
				
				// Get the hash from the original path, it will be something like /path/to/torrentName_hash/torrentfolder/file.mkv|avi|etc
				// The hash is always 40 characters as it is SHA1
				$hashRegex = "/_([\w]{40})\//";
				
				$matchesHash = array();
				
				if(preg_match($hashRegex, $originalPath, $matchesHash)) {
					$hash = $matchesHash[1];
					$this->logger->debug("[RENAMING] Torrent hash is:  $hash");
					
					$torrent = $this->findTorrentByHash($hash);
					
					if ($torrent != null && $torrent->getState() !== TorrentState::COMPLETED) {
							
						$torrent->setState(TorrentState::COMPLETED);
						$this->update($torrent);
							
					} else {
						$this->logger->warn("[RENAMING] Could not find torrent in DB with hash $hash");
					}
				} else {
					$this->logger->warn("[RENAMING] Could not detect hash in path $originalPath, fix path creation to follow '/path/to/torrentName_hash/torrentName/filename.ext'");	
				}
			}	
		} else {
			$this->logger->debug("[RENAMING] No torrents were detected in renamer log file $renamerLogFilePath");
		}	
	} 
}