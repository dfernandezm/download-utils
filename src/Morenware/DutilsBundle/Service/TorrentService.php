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
	private $monitorLogger;
	private $renamerLogger;
	
	/** @DI\Inject("processmanager.service") */
	public $processManager;
	
	/** @DI\Inject("transmission.service") */
	public $transmissionService;
	
	
   /**
	* @DI\InjectParams({
	*     "logger"           = @DI\Inject("logger"),
	*     "monitorLogger"	 = @DI\Inject("monolog.logger.monitor"),
	*     "renamerLogger"	 = @DI\Inject("monolog.logger.renamer"),
	*     "debrilFeedReader" = @DI\Inject("debril.reader"),
	*     "entityClass"      = @DI\Inject("%morenware_dutils.torrent.class%")
	* })
	*
	*/
	public function __construct($logger, $monitorLogger, $renamerLogger, $debrilFeedReader, $entityClass) {

		$this->logger = $logger;
		$this->monitorLogger = $monitorLogger;
		$this->renamerLogger = $renamerLogger;
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
	
	public function findTorrentByHash($torrentHash) {
		return $this->getRepository()->findOneBy(array('hash' => $torrentHash));
	}
	
	public function findTorrentByMagnetLink($magnetLink) {
		return $this->getRepository()->findOneBy(array('magnetLink' => $magnetLink));
	}
	
	public function findTorrentByFilePath($torrentFilePath) {
		return $this->getRepository()->findOneBy(array('filePath' => $torrentFilePath));
	}
	
	public function clearDoctrine() {
		$this->em->flush();
		$this->em->clear();
	}
	
	public function updateDataForTorrents($torrentsResponse) {
		$countTorrents = count($torrentsResponse);
		
		// General logger
		$this->logger->info("Updating data for  $countTorrents torrents");
		
		foreach ($torrentsResponse as $torrentResponse) {
			
			$percentDone = 100 * $torrentResponse->percentDone;
			$transmissionId = $torrentResponse->id;
			$torrentName = $torrentResponse->name;
			$torrentHash = $torrentResponse->hashString;	
			
			$existingTorrent = $this->findTorrentByHash($torrentHash);
			
			if ($existingTorrent != null) {
				
				$torrentState = $existingTorrent->getState();
								
				$existingTorrent->setPercentDone($percentDone);
				$existingTorrent->setHash($torrentHash);

				if ($percentDone != null && $percentDone > 0 && $percentDone < 100 && 
					$existingTorrent->getState() != TorrentState::DOWNLOAD_COMPLETED && $existingTorrent->getState() != TorrentState::COMPLETED) {
					$existingTorrent->setState(TorrentState::DOWNLOADING);
					$this->monitorLogger->debug("Torrent $torrentName found in DB, setting as DOWNLOADING, state was $torrentState, percent $percentDone");	
				} else if ($percentDone == 100 && $torrentState == TorrentState::DOWNLOADING) {
					$existingTorrent->setState(TorrentState::DOWNLOAD_COMPLETED);
					$this->monitorLogger->info("[MONITOR] Torrent $torrentName finished downloading, percent $percentDone, starting renaming process");
					$this->logger->info("[MONITOR] Torrent $torrentName finished downloading, starting renaming process");
					$this->startRenamerIfNotAlready();
				}
				
				$this->merge($existingTorrent);
				
			} else {
				$this->monitorLogger->debug("Torrent $torrentName with hash $torrentHash not found in DB, creating and relocating now");
				
				// Relocate the torrent to the known subfolder as we are creating it now
				
				try {
					$this->transmissionService->configureTransmission();
					$this->transmissionService->relocateTorrent($torrentName, $torrentHash);
				} catch (\Exception $e) {
					$this->logger->error("Error configuring transmission / relocating torrent -- " . $e->getMessage());
					$this->monitorLogger->debug("Error configuring transmission / relocating torrent -- " . $e->getMessage());
				}
				
				$torrent = new Torrent();
				$torrent->setTransmissionId($transmissionId);
				$torrent->setGuid(GuidGenerator::generate());
				$torrent->setTorrentName($torrentName);
			    
			    if ($percentDone > 0 && $percentDone < 100) {
					$torrent->setState(TorrentState::DOWNLOADING);
					$this->monitorLogger->debug("Torrent $torrentName, setting as DOWNLOADING, percent $percentDone");
				} else if ($percentDone == 100) {
					$torrent->setState(TorrentState::DOWNLOAD_COMPLETED);
					$this->monitorLogger->info("[MONITOR] Torrent $torrentName finished downloading, percent $percentDone, starting renaming process");
					$this->logger->info("[MONITOR] Torrent $torrentName finished downloading, starting renaming process");
					$this->startRenamerIfNotAlready();
				}
				
				$torrent->setTitle($torrentName);
				$torrent->setHash($torrentHash);
				
				// TODO: try to discover if it is movie or tv show using filebot here??
				$torrent->setContentType(TorrentContentType::TV_SHOW);
				$torrent->setPercentDone($percentDone);
				
				$this->create($torrent);
			}
		}
		
		$this->monitorLogger->debug("[MONITOR] Finished torrents update");
	}
	
	//TODO: we can use a subfolder (known) for each torrent when adding it and it would be easier to do this!
	// For torrent added outside of here, we can rename/relocate it with a JSON RPC method
	
	/**
	 * Looks up in the renamer log file matching paths of renaming to identify torrents by its name
	 * 
	 * @param unknown $renamerLogFilePath
	 */
	public function processTorrentsAfterRenaming($renamerLogFilePath) {
		
		$this->logger->info("[RENAMING] Starting state update of torrents after renaming using renamer log file $renamerLogFilePath");
		
		$pathMovedPattern = '/\[MOVE\]\s+Rename\s+(.*)to\s+\[(.*)\]/';
		$logContent = file_get_contents($renamerLogFilePath);
		
		$matches = array();
		
		if (preg_match_all($pathMovedPattern, $logContent, $matches)) {
			
			$originalPathList = $matches[1];
			$newPathList = $matches[2];
			$this->renamerLogger->debug("[RENAMING] Matched renamed paths");
			for ($i = 0; $i < count($originalPathList); $i++) {
				
				$originalPath = $originalPathList[$i];
				$newPath = $newPathList[$i];
				
				$this->renamerLogger->debug("[RENAMING] Detected renamed path: $originalPath ===> $newPath");
				
				// This is the same as it would be $newPath.endsWith(".srt")
				if (strrpos($newPath, ".srt", strlen($newPath) - strlen(".srt")) !== false) {
					// This is a subtitle, move on
					continue;
				}
				
				// Get the hash from the original path, it will be something like /path/to/torrentName_hash/torrentfolder/file.mkv|avi|etc
				// The hash is always 40 characters as it is SHA1
				$hashRegex = "/_([\w]{40})/";
				
				$matchesHash = array();
				
				if(preg_match($hashRegex, $originalPath, $matchesHash)) {
					$hash = $matchesHash[1];
					$this->renamerLogger->debug("[RENAMING] Torrent hash is: $hash");
					
					$torrent = $this->findTorrentByHash($hash);
					
					if ($torrent != null && $torrent->getState() !== TorrentState::COMPLETED) {
							
						$torrent->setState(TorrentState::COMPLETED);
						$this->update($torrent);
						$torrentName = $torrent->getTorrentName();
						$this->renamerLogger->debug("[RENAMING] Completing processing for torrent $torrentName with hash $hash");
						
						//TODO: Further linking with Asset id, 
						//$contentName = (get tv show title from new path (convention?)
							
					} else {
						$this->renamerLogger->warn("[RENAMING] Could not find torrent in DB with hash $hash");
					}
				} else {
					$this->renamerLogger->warn("[RENAMING] Could not detect hash in path $originalPath, fix path creation to follow '/path/to/torrentName_hash/torrentName/filename.ext'");	
				}
			}	
		} else {
			$this->renamerLogger->debug("[RENAMING] No torrents were detected in renamer log file $renamerLogFilePath");
		}	
	}

	/**
	 * Starts a renamer process for the downloads folder if no one has been started yet
	 * 
	 */
	public function startRenamerIfNotAlready() {
		$this->processManager->startSymfonyCommandAsynchronously(CommandType::RENAME_DOWNLOADS);
	}
	
	public function startDownloadFromMagnetLink($magnetLink, $origin = null) {
	
		$this->logger->debug("Starting download from link $magnetLink");	
		$torrent = $this->findTorrentByMagnetLink($magnetLink);
	
		if ($torrent != null) {
			return $this->startDownload($torrent);
		} else {
			$torrent = new Torrent();
			$torrent->setMagnetLink($magnetLink);
			$torrent->setGuid(GuidGenerator::generate());
			$torrent->setTitle("Unknown");
				
			if ($origin != null) {
				$torrent->setOrigin($origin);
			}
				
			return $this->transmissionService->startDownload($torrent);
		}
	}
	
	public function startDownloadFromTorrentFile($torrentFilePath, $origin = null) {
		$torrent = $this->findTorrentByFilePath($torrentFilePath);
	
		if ($torrent != null) {
			return $this->transmissionService->startDownload($torrent);
		} else {
			$torrent = new Torrent();
			$torrent->setMagnetLink($torrentFilePath);
			$torrent->setGuid(GuidGenerator::generate());
			$torrent->setTitle("Unknown");
	
			if ($origin != null) {
				$torrent->setOrigin($origin);
			}
	
			return $this->transmissionService->startDownload($torrent);
		}
	}
}