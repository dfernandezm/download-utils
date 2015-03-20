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
	
	private $transmissionConfigured = false;
	
	
   /**
	* @DI\InjectParams({
	*     "logger"           = @DI\Inject("monolog.logger"),
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
	
	private function delete($torrent) {
		$this->em->remove($torrent);
	}
	
	public function findTorrentByHash($torrentHash) {
		$torrent = $this->getRepository()->findOneBy(array('hash' => $torrentHash));
		$this->em->flush();
		$this->em->clear();
		return $torrent;
	}
	
	public function findTorrentByMagnetLink($magnetLink) {
		return $this->getRepository()->findOneBy(array('magnetLink' => $magnetLink));
	}
	
	public function findTorrentByFileLink($torrentFileLink) {
		return $this->getRepository()->findOneBy(array('torrentFileLink' => $torrentFileLink));
	}
	
	public function findTorrentsByState($torrentState) {
		return $this->getRepository()->findBy(array('state' => $torrentState));
	}
	
	public function findTorrentByGuid($guid) {
		return $this->getRepository()->findOneBy(array('guid' => $guid));
	}
	
	public function deleteTorrent($torrent, $deleteInTransmission = true) {
		
		if (!$deleteInTransmission) {
			$this->delete($torrent);
			$this->em->flush();
		} else {
			
			$this->em->transactional(function($em) use ($torrent) {
				$this->transmissionService->deleteTorrent($torrent->getHash());
				$this->delete($torrent);		
			});	
		}	

	}
	
	public function updateDataForTorrents($torrentsResponse) {
		$countTorrents = count($torrentsResponse);
		$finishedTorrents = array();
		
		$updatedTorrents = array();
		
		// General logger
		$this->monitorLogger->info("Updating data for $countTorrents torrents");
		
		foreach ($torrentsResponse as $torrentResponse) {
			
			$percentDone = 100 * $torrentResponse->percentDone;
			$transmissionId = $torrentResponse->id;
			$torrentName = $torrentResponse->name;
			$torrentHash = $torrentResponse->hashString;	
			$magnetLink = $torrentResponse->magnetLink;
				
			$existingTorrent = $this->findTorrentByHash($torrentHash);
			
			$this->monitorLogger->debug("Torrent HASH is $torrentHash");
			
			if ($existingTorrent !== null) {
				
				$torrentState = $existingTorrent->getState();							
				$existingTorrent->setMagnetLink($magnetLink);
				
				$existingTorrentName = $existingTorrent->getTorrentName();
				$existingTorrentPercent = $existingTorrent->getPercentDone();
				
				if ($torrentState == TorrentState::DOWNLOADING) {
					$this->monitorLogger->debug("Torrent response: $torrentName is DOWNLOADING state read is $torrentState, percentage read $percentDone");
					$this->monitorLogger->debug("Torrent DB: $existingTorrentName is DOWNLOADING, stored percentage is $existingTorrentPercent");
				} else {
					$this->monitorLogger->debug("Torrent response: $torrentName state is $torrentState, percentage read $percentDone");
					$this->monitorLogger->debug("Torrent DB: $existingTorrentName is $torrentState, stored percentage is $existingTorrentPercent");
				}
				
				if ($percentDone != null && $percentDone > 0 && $percentDone < 100 && 
					$torrentState !== TorrentState::DOWNLOAD_COMPLETED &&
					$torrentState !== TorrentState::RENAMING &&
					$torrentState !== TorrentState::RENAMING_COMPLETED &&
					$torrentState !== TorrentState::FETCHING_SUBTITLES &&
					$torrentState !== TorrentState::FAILED_DOWNLOAD_ATTEMPT &&
					$torrentState !== TorrentState::COMPLETED) {

					$existingTorrent->setPercentDone($percentDone);
					
					if ($torrentState == TorrentState::DOWNLOADING) {
						$existingTorrent->setState(TorrentState::DOWNLOADING);
						$this->monitorLogger->debug("Torrent $torrentName found in DB, setting as DOWNLOADING");
					}
						
				} else if ($percentDone == 100 && ($torrentState == TorrentState::DOWNLOADING || $torrentState == null || $torrentState == '')) {
					
					$existingTorrent->setPercentDone($percentDone);
					$existingTorrent->setState(TorrentState::DOWNLOAD_COMPLETED);
					$this->monitorLogger->info("[MONITOR] Torrent $torrentName finished downloading, percent $percentDone, starting renaming process");
					$this->logger->info("[MONITOR] Torrent $torrentName finished downloading, starting renaming process");
					$finishedTorrents[] = $existingTorrent;
				}
				
				$this->merge($existingTorrent);
				
				$updatedTorrents[] = $existingTorrent;
				
				// Clear finished torrents from transmission
				if ($torrentState == TorrentState::COMPLETED) {
					$this->transmissionService->deleteTorrent($existingTorrent->getHash());
				}
				
			} else {
				
				$finished = false;
				
				$this->monitorLogger->debug("Torrent $torrentName with hash $torrentHash not found in DB, creating and relocating now");
				
				// Relocate the torrent to the known subfolder as we are creating it now
				$newLocation = null;
				
				try {
					
					if (!$this->transmissionConfigured) {
						$this->transmissionService->configureTransmission();
						$this->transmissionConfigured = true;	
					}
					
					$newLocation = $this->transmissionService->relocateTorrent($torrentName, $torrentHash);
				
				} catch (\Exception $e) {
					$this->logger->error("Error configuring transmission / relocating torrent -- " . $e->getMessage());
					$this->monitorLogger->debug("Error configuring transmission / relocating torrent -- " . $e->getMessage());
					return;
				}
				
				$torrent = new Torrent();
				$torrent->setFilePath($newLocation);
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
					$finished = true;
				}
				
				$torrent->setTitle($torrentName);
				$torrent->setHash($torrentHash);
				
				// TODO: try to discover if it is movie or tv show using filebot here??
				$torrent->setContentType(TorrentContentType::TV_SHOW);
				$torrent->setPercentDone($percentDone);
				$torrent->setMagnetLink($magnetLink);
				
				$this->create($torrent);
				
				if ($finished) {
					$finishedTorrents[] = $torrent;
				}
				
				$updatedTorrents[] = $torrent;
			}
		}
		
		if (count($finishedTorrents) > 0) {
			$this->monitorLogger->debug("[MONITOR] Finished torrents update -- There are torrents to rename");
		} else {
			$this->monitorLogger->debug("[MONITOR] Finished torrents update -- No torrents to rename");
		}
		
		return $updatedTorrents;
	}

	
	/**
	 * Looks up in the renamer log file matching paths of renaming to identify torrents by its name
	 * 
	 * @param unknown $renamerLogFilePath
	 */
	public function processTorrentsAfterRenaming($renamerLogFilePath) {
		
		$this->logger->info("[RENAMING] Starting state update of torrents / subtitle fetching after renaming using renamer log file $renamerLogFilePath");
		
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
					
					if ($torrent != null && 
						$torrent->getState() == TorrentState::RENAMING &&
						$torrent->getState() !== TorrentState::RENAMING_COMPLETED && 
						$torrent->getState() !== TorrentState::COMPLETED) {
							
						$torrentName = $torrent->getTorrentName();
						
				        //TODO: Get subtitles requirement for this Movie/TV Show in the current profile
						$requireSubtitles = true;
						$torrent->setRenamedPath($newPath);
						
						if ($requireSubtitles) {
							$torrent->setState(TorrentState::RENAMING_COMPLETED);	
							$this->renamerLogger->debug("[RENAMING] With subtitles, completing renaming process for torrent $torrentName with hash $hash -- RENAMING_COMPLETED");
						} else {
							$torrent->setState(TorrentState::COMPLETED);
							$this->renamerLogger->debug("[RENAMING] Completing renaming process for torrent $torrentName with hash $hash -- COMPLETED");
							$this->monitorLogger->info("[WORKFLOW-FINISHED] COMPLETED processing $torrentName");
							$this->clearTorrentFromTransmissionIfSuccessful($torrent);
						}
						
						$this->update($torrent);
						
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
	
	
	public function startDownloadFromMagnetLink($magnetLink, $origin = null) {
	
		$this->logger->debug("Starting download from link $magnetLink");	
		$torrent = $this->findTorrentByMagnetLink($magnetLink);
	
		if ($torrent == null) {
			$torrent = new Torrent();
			$torrent->setMagnetLink($magnetLink);
			$torrent->setGuid(GuidGenerator::generate());
			$torrent->setTitle("Unknown");
				
			if ($origin != null) {
				$torrent->setOrigin($origin);
			}
		}
		
		return $this->transmissionService->startDownload($torrent);
	}
	
	public function startDownloadFromTorrentFile($torrentFileLink, $origin = null) {
		$this->logger->debug("Starting download from torrent file  $torrentFileLink");
		$torrent = $this->findTorrentByFileLink($torrentFileLink);
	
		if ($torrent == null) {
			$torrent = new Torrent();
			$torrent->setTorrentFileLink($torrentFileLink);
			$torrent->setGuid(GuidGenerator::generate());
			$torrent->setTitle("Unknown");
	
			if ($origin != null) {
				$torrent->setOrigin($origin);
			}
		}
		
		return $this->transmissionService->startDownload($torrent, true);
	}
	
	public function getTorrentsPathsAsBashArray($torrents, $baseDownloadsOrLibraryPath, $renamerOrSubtitles) {
		
		$torrentsPathsAsBashArray = "(";
		
		foreach ($torrents as $torrent) {
			
           $torrentPath = "";
           $targetState = "";
           if ($renamerOrSubtitles == CommandType::RENAME_DOWNLOADS) {
             $torrentPath = $torrent->getFilePath();
             $targetState = TorrentState::RENAMING;
             $this->renamerLogger->debug("[RENAMING] Torrent to process " . $torrent->getFilePath());        
           } else if ($renamerOrSubtitles == CommandType::FETCH_SUBTITLES) {
           	 $torrentPath = $torrent->getRenamedPath();
           	 $targetState = TorrentState::FETCHING_SUBTITLES;
           	 $this->renamerLogger->debug("[SUBTITLES] Torrent to process " . $torrent->getFilePath());
           	  
           }
		
		   $torrentDir = "";
		   
		   if (is_dir($torrentPath)) {
		   	 $torrentDir = $torrentPath;
		   } else {
		   	 $torrentDir = dirname($torrentPath);
		   }
		   
		   $torrentsPathsAsBashArray = $torrentsPathsAsBashArray . "\"" . $torrentDir . "\" ";
		   $torrent->setState($targetState);
		   $this->update($torrent);
		}
	
		$torrentsPathsAsBashArray = trim($torrentsPathsAsBashArray) . ")";
		
		$this->renamerLogger->debug("The bash array created is: " . $torrentsPathsAsBashArray);
		
		return $torrentsPathsAsBashArray;
	}
	
	public function finishProcessingAfterFetchingSubs() {
		$subtitledTorrents = $this->findTorrentsByState(TorrentState::FETCHING_SUBTITLES);
		
		foreach ($subtitledTorrents as $torrent) {
			$torrent->setState(TorrentState::COMPLETED);
			$this->merge($torrent);
			$torrentName = $torrent->getTorrentName();
			$this->monitorLogger->info("[WORKFLOW-FINISHED] COMPLETED processing $torrentName after fetching subtitles");
			$this->clearTorrentFromTransmissionIfSuccessful($torrent);
		}

		$this->monitorLogger->info("[WORKFLOW-FINISHED] Processing of torrents finished");
	}
	
	public function findTorrentByMagnetOrFile($magnetOrTorrentFile) {
		
		$torrent = null;
		
		if ($this->endsWith($magnetOrTorrentFile,".torrent")) {
			// It is a torrent file link
			$torrent = $this->findTorrentByFileLink($magnetOrTorrentFile);
		} else {
			// Assume a magnet link
			$torrent = $this->findTorrentByMagnetLink($magnetOrTorrentFile);
		}
		
		return $torrent;
	}
	
	public function endsWith($target, $suffix) {
		return strrpos($target, $suffix, strlen($target) - strlen($suffix)) !== false;
	}

	
	public function clearTorrentFromTransmissionIfSuccessful($torrent) {
		//TODO: if remote, the path could not be accessible
		if (file_exists($torrent->getRenamedPath())) {
			$this->transmissionService->deleteTorrent($torrent->getHash());
		} else {
			$renamedPath = $torrent->getRenamedPath();
			$this->monitorLogger->warn("[MONITOR-WARNING] The processed torrent does not have a valid renamed path -- $renamedPath");
			$torrent->setState(TorrentState::COMPLETED_WITH_ERROR);
			$this->update($torrent);
		}
	}
	
}