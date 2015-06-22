<?php
namespace Morenware\DutilsBundle\Service;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\Common\Persistence\ObjectManager;
use Monolog\Logger;
use Morenware\DutilsBundle\Entity\Torrent;
use Morenware\DutilsBundle\Entity\TorrentOrigin;
use Morenware\DutilsBundle\Entity\TorrentContentType;
use Morenware\DutilsBundle\Entity\TorrentState;
use Morenware\DutilsBundle\Entity\Feed;
use Morenware\DutilsBundle\Util\GuidGenerator;
use Morenware\DutilsBundle\Util\GlobalParameters;

/** @Service("torrent.service") */
class TorrentService {

	/** @DI\Inject("doctrine.orm.entity_manager")
     *  @var \Doctrine\ORM\EntityManager $em
     */
	public $em;

    /** @var \Doctrine\ORM\EntityRepository $repository */
	private $repository;
	private $entityClass;
	private $logger;
	private $monitorLogger;
	private $renamerLogger;

	/** @DI\Inject("processmanager.service")
     * @var \Morenware\DutilsBundle\Service\ProcessManager $processManager
     */
	public $processManager;

	/** @DI\Inject("transmission.service")
     *  @var \Morenware\DutilsBundle\Service\TransmissionService $transmissionService
     */
	public $transmissionService;

	/** @DI\Inject("transaction.service")
     * @var \Morenware\DutilsBundle\Util\TransactionService $transactionService
     */
	public $transactionService;

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
	public function __construct(Logger $logger, Logger $monitorLogger,  Logger $renamerLogger, $debrilFeedReader, $entityClass) {

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

	/** Warning: needs to be executed inside a transaction, otherwise does not hit the DB */
	public function merge($torrent) {
		$this->em->merge($torrent);
	}

	/* Implicit transaction */
	public function update($torrent) {
		$this->em->merge($torrent);
		$this->em->flush();
		$this->em->clear();
	}

	public function find($id) {
		return $this->em->find($id);
	}

	public function getAll() {
		return $this->getRepository()->findAll();
	}

	public function getAllOrderedByDate() {
		return $this->getRepository()->findBy(array(), array('date' => 'DESC'));
	}
	
	public function getAllNonCompletedOrderedByDate() {
		
		$upperDate = new \DateTime();
		$lowerDate = new \DateTime();
		$interval = \DateInterval::createFromDateString("-5 years");
		$lowerDate = $lowerDate->add($interval);
//        $interval = \DateInterval::createFromDateString("+1 hour");
//        $upperDate = $upperDate->add($interval);
		
		$q = $this->em->createQuery("select t from MorenwareDutilsBundle:Torrent t " . 
				                    "where t.dateStarted between :lowerDate and :upperDate " .
				                    "order by t.dateStarted DESC")
		                            ->setParameter("lowerDate", $lowerDate->format("Y-m-d H:i"))
		                            ->setParameter("upperDate", $upperDate->format("Y-m-d H:i"));
		$torrents = $q->getResult();
		return $torrents;	
	}


	public function delete($torrent) {
		$this->em->remove($torrent);
		$this->em->flush();
		$this->em->clear();
	}

	/** Needs to be executed inside transaction */
	private function remove($torrent) {
		$this->em->remove($torrent);
	}

	public function findTorrentByHash($torrentHash) {
		$torrent = $this->getRepository()->findOneBy(array('hash' => $torrentHash));
		$this->em->flush();
		$this->em->clear();
		return $torrent;
	}

	public function findByHashIsolated($torrentHash) {
		$torrent = $this->getRepository()->findOneBy(array('hash' => $torrentHash));
		return $torrent;
	}

	public function findTorrentByMagnetLink($magnetLink) {
		$torrent = $this->getRepository()->findOneBy(array('magnetLink' => $magnetLink));
		$this->em->flush();
		$this->em->clear();
		return $torrent;
	}

	public function findTorrentByFileLink($torrentFileLink) {
		$torrent = $this->getRepository()->findOneBy(array('torrentFileLink' => $torrentFileLink));
		$this->em->flush();
		$this->em->clear();
		return $torrent;
	}

	public function findTorrentsByState($torrentState) {
		$torrents = $this->getRepository()->findBy(array('state' => $torrentState), array('date' => 'DESC'));
		$this->em->flush();
		$this->em->clear();
		return $torrents;
	}

	public function findTorrentByGuid($guid) {
		$torrent = $this->getRepository()->findOneBy(array('guid' => $guid));
		$this->em->flush();
		$this->em->clear();
		return $torrent;
	}

	public function deleteTorrent(Torrent $torrent, $deleteInTransmission = true) {

		if (!$deleteInTransmission) {
			$this->delete($torrent);
		} else {

			$this->transactionService->executeInTransactionWithRetryUsingProvidedEm($this->em, function() use ($torrent) {
				// Fetch and Re-attach entity, as the object passed is a UI one
			    $torrent = $this->findByHashIsolated($torrent->getHash());
				$this->merge($torrent);
				$this->remove($torrent);
				$this->transmissionService->deleteTorrent($torrent->getHash());
			});

		}

	}

	public function updateDataForTorrents($torrentsResponse) {

		$countTorrents = count($torrentsResponse);
		$finishedTorrents = array();
		$updatedTorrents = array();

		// General logger
		$this->monitorLogger->info("[UPDATE-TORRENTS] Updating data for $countTorrents torrents");

		foreach ($torrentsResponse as $torrentResponse) {

			$percentDone = 100 * $torrentResponse->percentDone;
			$transmissionId = $torrentResponse->id;
			$torrentName = $torrentResponse->name;
			$torrentHash = $torrentResponse->hashString;
			$magnetLink = $torrentResponse->magnetLink;

            /* Torrent $existingTorrent */
			$existingTorrent = $this->findTorrentByHash($torrentHash);

			$this->monitorLogger->debug("[UPDATE-TORRENTS] Torrent HASH is $torrentHash");

			if ($existingTorrent !== null) {

				$torrentState = $existingTorrent->getState();
				$existingTorrent->setMagnetLink($magnetLink);

				$existingTorrentName = $existingTorrent->getTorrentName();
				$existingTorrentPercent = $existingTorrent->getPercentDone();

				if ($torrentState == TorrentState::DOWNLOADING) {
					$this->monitorLogger->debug("[UPDATE-TORRENTS] Torrent response: $torrentName is DOWNLOADING state read is $torrentState, percentage read $percentDone");
					$this->monitorLogger->debug("[UPDATE-TORRENTS] Torrent DB: $existingTorrentName is DOWNLOADING, stored percentage is $existingTorrentPercent");
				} else {
					$this->monitorLogger->debug("[UPDATE-TORRENTS] Torrent response: $torrentName state is $torrentState, percentage read $percentDone");
					$this->monitorLogger->debug("[UPDATE-TORRENTS] Torrent DB: $existingTorrentName is $torrentState, stored percentage is $existingTorrentPercent");
				}

				if ($percentDone != null && $percentDone > 0 && $percentDone < 100 &&
                    $existingTorrentPercent != 100 &&
					$torrentState !== TorrentState::DOWNLOAD_COMPLETED &&
					$torrentState !== TorrentState::RENAMING &&
					$torrentState !== TorrentState::RENAMING_COMPLETED &&
					$torrentState !== TorrentState::FETCHING_SUBTITLES &&
					$torrentState !== TorrentState::FAILED_DOWNLOAD_ATTEMPT &&
					$torrentState !== TorrentState::COMPLETED) {

					$existingTorrent->setPercentDone($percentDone);

					if ($torrentState !== TorrentState::DOWNLOADING && $torrentState !== TorrentState::PAUSED) {
						$existingTorrent->setState(TorrentState::DOWNLOADING);
						$this->monitorLogger->debug("Torrent $torrentName found in DB, setting as DOWNLOADING");
					}

				} else if ($percentDone == 100 && ($torrentState == TorrentState::DOWNLOADING || $torrentState == null || $torrentState == '')) {

					$existingTorrent->setPercentDone($percentDone);
					$existingTorrent->setState(TorrentState::DOWNLOAD_COMPLETED);
                    $existingTorrent->setDateFinished(new \DateTime());

					$this->monitorLogger->info("[UPDATE-TORRENTS] Torrent $torrentName finished downloading, percent $percentDone, starting renaming process");
					$this->logger->info("[UPDATE-TORRENTS] Torrent $torrentName finished downloading, starting renaming process");
					$finishedTorrents[] = $existingTorrent;
				}

				$this->update($existingTorrent);
				$updatedTorrents[] = $existingTorrent;

				// Clear finished torrents from Transmission directly
				if ($torrentState == TorrentState::COMPLETED) {
					$this->transmissionService->deleteTorrent($existingTorrent->getHash());
				}

			} else {

				$finished = false;
				$this->monitorLogger->debug("[UPDATE-TORRENTS] Torrent $torrentName with hash $torrentHash not found in DB, creating and relocating now");

				$torrent = new Torrent();

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
					$this->monitorLogger->error("Error configuring transmission / relocating torrent -- " . $e->getMessage());
					return $updatedTorrents;
				}

				$torrent->setFilePath($newLocation);
				$torrent->setTransmissionId($transmissionId);
				$torrent->setGuid(GuidGenerator::generate());
				$torrent->setTorrentName($torrentName);
                $torrent->setDateStarted(new \DateTime());

			    if ($percentDone > 0 && $percentDone < 100) {
					$torrent->setState(TorrentState::DOWNLOADING);
					$this->monitorLogger->debug("[UPDATE-TORRENTS] Torrent $torrentName, setting as DOWNLOADING, percent $percentDone");
				} else if ($percentDone == 100) {
					$torrent->setState(TorrentState::DOWNLOAD_COMPLETED);
					$this->monitorLogger->info("[UPDATE-TORRENTS] Torrent $torrentName finished downloading, percent $percentDone, starting renaming process");
					$this->logger->info("[UPDATE-TORRENTS] Torrent $torrentName finished downloading, starting renaming process");
                    $existingTorrent->setDateFinished(new \DateTime());
					$finished = true;
				}

				$torrent->setTitle($torrentName);
				$torrent->setHash($torrentHash);

				$torrent->setContentType(null);
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
			$this->monitorLogger->debug("[UPDATE-TORRENTS] Finished torrents update -- There are torrents to rename");
		} else {
			$this->monitorLogger->debug("[UPDATE-TORRENTS] Finished torrents update -- No torrents to rename");
		}

		return $updatedTorrents;
	}


	/**
	 * Looks up in the renamer log file matching paths of renaming to identify torrents by its name
	 *
	 * @param unknown $renamerLogFilePath
	 */
	public function processTorrentsAfterRenaming($renamerLogFilePath, $torrentsToRename) {

		$this->logger->info("[RENAMING] Starting state update of torrents / subtitle fetching after renaming using renamer log file $renamerLogFilePath");

		$pathMovedPattern = '/\[MOVE\]\s+Rename\s+(.*)to\s+\[(.*)\]/';
		$pathSkippedPattern = "/Skipped\s+\[(.*)\]\s+because\s+\[(.*)\]/";
		$hashRegex = "/_([\w]{40})/";

		$logContent = file_get_contents($renamerLogFilePath);
		$matches = array();

        // Regular case: detected MOVED path
		if (preg_match_all($pathMovedPattern, $logContent, $matches)) {

			$originalPathList = $matches[1];
			$newPathList = $matches[2];
			$moreThanOnePathHashes = array();
			$renamedPaths = array();

			$this->renamerLogger->debug("[RENAMING] Matched renamed paths");
			for ($i = 0; $i < count($originalPathList); $i++) {

				$originalPath = $originalPathList[$i];
				$newPath = $newPathList[$i];

				$this->renamerLogger->debug("[RENAMING] Detected renamed path: $originalPath ==> $newPath");

				// Get the hash from the original path, it will be something like /path/to/torrentName_hash/torrentfolder/file.mkv|avi|etc
				// The hash is always 40 characters as it is SHA1
				$matchesHash = array();

				if(preg_match($hashRegex, $originalPath, $matchesHash)) {

					$hash = $matchesHash[1];

					$numberOfPaths = $this->countNumberOfOccurrencesOfHash($originalPathList,$hash);
					$this->renamerLogger->debug("[RENAMING] There are $numberOfPaths renamed for torrent with hash $hash");

					$torrent = $this->findTorrentByHash($hash);

					// Add path to list
					$this->renamerLogger->debug("[RENAMING] Adding renamed path $newPath");
					$renamedPaths[] = $newPath;

					if ($numberOfPaths == 1) {
						// process the torrent -- regular case 1 torrent = 1 file
						$this->processSingleTorrentWithRenamedData($torrent, $hash, $renamedPaths, false);
						$renamedPaths = array();

					} else {
						// several files in the torrent have been renamed
						if (!array_key_exists($hash, $moreThanOnePathHashes)) {
							$moreThanOnePathHashes[$hash] = $numberOfPaths - 1;
							$this->renamerLogger->debug("[RENAMING] Computing number of paths for hash $hash, currently " . $moreThanOnePathHashes[$hash]);
						} else {

							$remainingNumberOfPaths = $moreThanOnePathHashes[$hash];
							$this->renamerLogger->debug("[RENAMING] Remaining paths to process for hash $hash is $remainingNumberOfPaths");
							if ($remainingNumberOfPaths > 1) {
								$moreThanOnePathHashes[$hash] = $remainingNumberOfPaths - 1;
							} else {
							   // The last one, process the torrent
							   $this->renamerLogger->debug("[RENAMING] Multiple renamed paths, last path -- processing torrent with hash $hash");
							   $this->processSingleTorrentWithRenamedData($torrent, $hash, $renamedPaths, false);
							   $renamedPaths = array();
							   $moreThanOnePathHashes = array();
							}
						}
					}

				} else {
					$this->renamerLogger->warn("[RENAMING] Could not detect hash in path $originalPath, fix path creation to follow '/path/to/torrentName_hash/torrentName/filename.ext'");
				}
			}
		} else {

			$this->renamerLogger->debug("[RENAMING] No torrents were detected in renamer log file $renamerLogFilePath");
			$this->renamerLogger->debug("[RENAMING] Checking for errors in the log file and if files were moved or not -- $renamerLogFilePath");

			// This is a boundary case, the file still exists in the original path and can exist in the moved path
			if (preg_match_all($pathSkippedPattern, $logContent, $matches)) {

				$skippedOriginalPathList = $matches[1];
				$skippedNewPathList = $matches[2];

				for ($i = 0; $i < count($skippedOriginalPathList); $i++) {

					$skippedOriginalPath = $skippedOriginalPathList[$i];
					$skippedNewPath = $skippedNewPathList[$i];

					$this->renamerLogger->debug("[RENAMING-SKIPPED] Skipped path detected $skippedOriginalPath ==> $skippedNewPath");

					$matchesHash = array();

					if(preg_match($hashRegex, $skippedOriginalPath, $matchesHash)) {

						$hash = $matchesHash[1];
						$torrent = $this->findTorrentByHash($hash);

						$this->renamerLogger->debug("[RENAMING-SKIPPED] Skipped torrent detected with hash $hash -- " . $torrent->getTorrentName());

						//TODO: Does not check for multiple renamed paths yet
						$torrent->setRenamedPath($skippedNewPath);

						// Try to clear this torrent from transmission if successful: This could happen, as
						// Filebot can potentially left the file in both places (old and new, needs investigation
						// but happened once). So we can clear the torrent and new and old paths.

						// This process can leave the torrent in two states:
						// 1. COMPLETED_WITH_ERROR if the target path does not exist so,
						//    -> Go back to DOWNLOAD_COMPLETED if the original path (files) still exist
						// 2. The original state, RENAMING
						//    -> Move to RENAMING_COMPLETED if the target path exists

						$this->clearTorrentFromTransmissionIfSuccessful($torrent);

						if ($torrent->getState() == TorrentState::COMPLETED_WITH_ERROR) {

							// Check if the original path exists
							if (file_exists($skippedOriginalPath)) {
								// The original path is still there, so leave this for the next renaming attempts
								$torrent->setState(TorrentState::DOWNLOAD_COMPLETED);
								$this->renamerLogger->warn("[RENAMING-SKIPPED] Skipped torrent renamed path does not exist but original path is still there, flag back to DOWNLOAD_COMPLETED");

							} else {
								// The file does not exist in the original path, and does not exist in the new path
								// We need to check manually where the file is (maybe Unsorted), flag this as error
								$this->renamerLogger->error("[RENAMING-SKIPPED] Skipped torrent paths are missing -- check manually where the file is $hash -- " . $torrent->getTorrentName());
							}

							// No file in destination, renamedPath is null
							$torrent->setRenamedPath(null);
							$this->update($torrent);
						} else {

							// The torrent has been successfully cleared from transmission and checked the renamed path exists, we can flag
							// it as successful
							$renamedPaths = array();
							$renamedPaths[] = $torrent->getRenamedPath();
							$this->processSingleTorrentWithRenamedData($torrent, $hash, $renamedPaths, true);
						}
					} else {
						$this->renamerLogger->warn("[RENAMING-SKIPPED] No torrent detected in skipped path $skippedOriginalPath");
					}
				}
			} else {
				//TODO: Treat here exclusions "Exclude ..." as skipped. This will depend on why Filebot excluded here (post in forum pending)
				$this->renamerLogger->error("[RENAMING-ERRORED] No torrents with skipped paths detected -- it is likely an error ocurred, move torrents back to DOWNLOAD_COMPLETED to attempt next time");

                foreach ($torrentsToRename as $torrent) {
                    $torrent->setState(TorrentState::DOWNLOAD_COMPLETED);
					$this->update($torrent);
					$this->renamerLogger->warn("[RENAMING-ERRORED] Torrent " . $torrent->getTitle() . " with hash ". $torrent->getHash() . " moved back to DOWNLOAD_COMPLETED");
				}		
			}
		}
	}

	public function startTorrentDownload(Torrent $torrent, $force = false) {

		$existingTorrent = null;
		$fromFile = true;

		if ($torrent->getTorrentFileLink() !== null) {

            $torrentFileLink = $torrent->getTorrentFileLink();
			$this->logger->debug("[TORRENT-API] Starting download from torrent file  $torrentFileLink");
			$existingTorrent = $this->findTorrentByFileLink($torrentFileLink);
        } else if ($torrent->getMagnetLink() !== null){

            $torrentMagnetLink = $torrent->getMagnetLink();
			$this->logger->debug("[TORRENT-API] Starting download from magnet  $torrentMagnetLink");
			$existingTorrent = $this->findTorrentByMagnetLink($torrentMagnetLink);
			$fromFile = false;
		} else {

            $this->logger->error("No fileLink or magnet provided for Torrent download ");

			// Not filelink or magnet provided
			throw new \Exception("No fileLink or magnet provided for Torrent download");
		}

		if (strlen($torrent->getTitle()) == 0 || $torrent->getTitle() == null) {
			$torrent->setTitle("Unknown");
		}

		if (strlen($torrent->getTorrentName()) == 0 || $torrent->getTorrentName() == null) {
			$torrent->setTorrentName("Unknown");
		}

		$downloadingTorrent = null;

		if ($existingTorrent == null || $existingTorrent->getState() == TorrentState::AWAITING_DOWNLOAD || $existingTorrent->getState() == TorrentState::NEW_DOWNLOAD) {

            if ($existingTorrent == null) {
                $torrent->setGuid(GuidGenerator::generate());
            }

			$downloadingTorrent = $this->transmissionService->startDownload($torrent, $fromFile);
		} else {
			if ($force || $existingTorrent->getState() == null) {
				$this->transactionService->executeInTransactionWithRetryUsingProvidedEm($this->em,
				 function() use ($existingTorrent, $torrent, $fromFile, $downloadingTorrent) {
					$this->deleteTorrent($existingTorrent, true);
					$torrent->setGuid(GuidGenerator::generate());
					$downloadingTorrent = $this->transmissionService->startDownload($torrent, $fromFile);
				 });


			} else {
				// This torrent is already downloading or terminated
				$this->logger->error("The torrent provided is already downloading or finished (duplicated) -- " . $existingTorrent->getTorrentName());
				return null;
			}
		}

		return $downloadingTorrent;
	}


	public function getTorrentsPathsAsBashArray($torrents, $baseDownloadsOrLibraryPath, $renamerOrSubtitles) {

		$torrentsPathsAsBashArray = "(";

        /**
         * @var Torrent $torrent
         */
		foreach ($torrents as $torrent) {

           $targetState = "";
           if ($renamerOrSubtitles == CommandType::RENAME_DOWNLOADS) {

             $torrentPath = $torrent->getFilePath();
             $this->sanitizeFileNames($torrentPath);
             $targetState = TorrentState::RENAMING;
             $this->renamerLogger->debug("[RENAMING] Torrent to process " . $torrent->getFilePath());
             $torrentsPathsAsBashArray = $this->addTorrentPathToBashArray($torrentPath, $torrentsPathsAsBashArray);

           } else if ($renamerOrSubtitles == CommandType::FETCH_SUBTITLES) {

               // Can be a semicolon separated value of paths
               $torrentPath = $torrent->getRenamedPath();
               $paths = explode(";", $torrentPath);

               if (count($paths) > 1) {
                   // Loop through all the paths and extract directories
                   foreach ($paths as $path) {
                       $torrentsPathsAsBashArray = $this->addTorrentPathToBashArray($path, $torrentsPathsAsBashArray);
                   }
               } else {
                   // Pick directory of the first to fetch subtitles
                   $torrentPath = $paths[0];
                   $torrentsPathsAsBashArray = $this->addTorrentPathToBashArray($torrentPath, $torrentsPathsAsBashArray);
               }

               $targetState = TorrentState::FETCHING_SUBTITLES;
               $this->renamerLogger->debug("[SUBTITLES] Torrent to process " . $torrent->getFilePath());
           }

		   $torrent->setState($targetState);
		   $this->update($torrent);
		}

		$torrentsPathsAsBashArray = trim($torrentsPathsAsBashArray) . ")";

		$this->renamerLogger->debug("The bash array created is: " . $torrentsPathsAsBashArray);

		return $torrentsPathsAsBashArray;
	}


    private function addTorrentPathToBashArray($torrentPath, $torrentsPathsAsBashArray) {

        if (is_dir($torrentPath)) {
            $torrentDir = $torrentPath;
        } else {
            $this->renamerLogger->debug("The torrentPath $torrentPath is directly a file, getting directory");
            $torrentDir = dirname($torrentPath);
        }

        // if the torrentDir is already in the bash array, return; add it otherwise
        if (strpos($torrentsPathsAsBashArray, $torrentDir) !== false) {
            return $torrentsPathsAsBashArray;
        } else {
            return $torrentsPathsAsBashArray . "\"" . $torrentDir . "\" ";
        }
    }


	public function finishProcessingAfterFetchingSubs() {

		$this->monitorLogger->warn("[AFTER-SUBS] Completing processing");
		$subtitledTorrents = $this->findTorrentsByState(TorrentState::FETCHING_SUBTITLES);

        /**
         * @var Torrent $torrent
         */
		foreach ($subtitledTorrents as $torrent) {

			$allSubtitlesPresent = $this->areSubtitlesPresentForRenamedPath($torrent->getRenamedPath());

			$torrentName = $torrent->getTorrentName();

			if (!$allSubtitlesPresent) {
				$this->monitorLogger->warn("[WORKFLOW-FINISHED] Torrent $torrentName has missing or failed subtitles, fall back RENAMING_COMPLETED");
				$torrent->setState(TorrentState::RENAMING_COMPLETED);
			} else {
				$torrent->setState(TorrentState::COMPLETED);
				$this->monitorLogger->info("[WORKFLOW-FINISHED] COMPLETED processing $torrentName after fetching subtitles");
			}

			$this->update($torrent);
		}

		$this->monitorLogger->info("[WORKFLOW-FINISHED] Processing of torrents finished");
	}

	public function endsWith($target, $suffix) {
		return strrpos($target, $suffix, strlen($target) - strlen($suffix)) !== false;
	}


	public function clearTorrentFromTransmissionIfSuccessful(Torrent $torrent) {

		// Check if remote, the path could not be accessible for the server this app is running (ensure it is mounted)

		$renamedPath = $torrent->getRenamedPath();

		if ($renamedPath == null) {
			$this->renamerLogger->warn("[TORRENT-ERROR] The processed torrent ". $torrent->getTorrentName()
				   . " does not have a valid renamed path or cannot be accessed -- $renamedPath");
			$torrent->setState(TorrentState::COMPLETED_WITH_ERROR);
			$this->update($torrent);
			return;
		}

		$renamedPathArray = explode(";",$renamedPath);

		foreach($renamedPathArray as $renamedPath) {

			if (!file_exists($renamedPath)) {
				$this->renamerLogger->warn("[TORRENT-ERROR] The processed torrent ". $torrent->getTorrentName()
						. " does not have a valid renamed path or cannot be accessed -- $renamedPath");
				$torrent->setState(TorrentState::COMPLETED_WITH_ERROR);
				$this->update($torrent);
				return;
			}
		}

		$this->transmissionService->deleteTorrent($torrent->getHash());
	}
	
	public function pauseTorrent($torrent) {
		$this->transmissionService->pauseTorrent($torrent->getHash());
		$torrent->setState(TorrentState::PAUSED);
		$this->update($torrent);
		return $torrent;
	}
	
	public function resumeTorrent($torrent) {
		$this->transmissionService->resumeTorrent($torrent->getHash());
		$torrent->setState(TorrentState::DOWNLOADING);
		$this->update($torrent);
		return $torrent;
	}

	private function requireSubtitles($newPath) {

		$noSubtitlesList = array("Castle", "Big Bang Theory", "La Que Se Avecina");
		$newPathLower = strtolower($newPath);

		foreach ($noSubtitlesList as $element) {
			if (strpos($newPathLower, strtolower($element)) !== false) {
				// is in the list, so no subtitles
				return false;
			}
		}

		return true;
	}

	public function clearSpecialChars($torrentName) {

		$torrentName = str_replace("ñ","n",$torrentName);
		$torrentName = str_replace("Ñ","N",$torrentName);
		$torrentName = str_replace("á","a",$torrentName);
		$torrentName = str_replace("é","e",$torrentName);
		$torrentName = str_replace("í","i",$torrentName);
		$torrentName = str_replace("ó","o",$torrentName);
		$torrentName = str_replace("ú","u",$torrentName);
		$torrentName = str_replace("Á","A",$torrentName);
		$torrentName = str_replace("É","E",$torrentName);
		$torrentName = str_replace("Í","I",$torrentName);
		$torrentName = str_replace("Ó","O",$torrentName);
		$torrentName = str_replace("Ú","U",$torrentName);
		$torrentName = str_replace(" ",".",$torrentName);
		$torrentName = str_replace("+",".",$torrentName);
		$torrentName = str_replace("?",".",$torrentName);

		$this->logger->debug("[TORRENT-SERVICE] Cleared torrentName is $torrentName");

		return $torrentName;
	}

	public function sanitizeFileNames($filePath) {

		if (is_dir($filePath)) {
			$fh = opendir($filePath);
			while (($file = readdir($fh)) !== false) {
				// skip hidden files and dirs and recursing if necessary
				if (strpos($file, '.') === 0) continue;

				$currentFilePath = $filePath . '/' . $file;
				if ( is_dir($currentFilePath) ) {
					$newName = $this->clearSpecialChars($currentFilePath);
					$this->logger->debug("[TORRENT-SERVICE] clearing From $currentFilePath To $newName");
					rename($currentFilePath, $newName);
					$this->sanitizeFileNames($newName);
				} else {
					$newname = $this->clearSpecialChars($currentFilePath);
					$this->logger->debug("[TORRENT-SERVICE] From $currentFilePath To $newName");
					rename($currentFilePath, $newname);
				}
			}
			closedir($fh);
		}
	}


	private function processSingleTorrentWithRenamedData(Torrent $torrent, $hash, $renamedPaths, $alreadyCleared = false) {

		if ($torrent !== null &&
			$torrent->getState()  == TorrentState::RENAMING &&
			$torrent->getState() !== TorrentState::RENAMING_COMPLETED &&
			$torrent->getState() !== TorrentState::COMPLETED) {

				// regular case: 1 Path per torrent
				$torrentName = $torrent->getTorrentName();

				$requireSubtitles = $this->requireSubtitles($renamedPaths[0]);

				if (count($renamedPaths) > 1) {
					// Semicolon separated value of all paths
					$renamedPath = implode(";",$renamedPaths);
				} else {
					$renamedPath = $renamedPaths[0];
				}

				$torrent->setRenamedPath($renamedPath);

				if ($requireSubtitles) {

					$torrent->setState(TorrentState::RENAMING_COMPLETED);
					$this->renamerLogger->debug("[RENAMING] With subtitles, completing renaming process for torrent $torrentName with hash $hash -- RENAMING_COMPLETED");

                    if (!$this->processManager->isSubtitleFetchWorkerRunning()) {
                        $this->processManager->startSubtitleFetchWorker();
                    }

				} else {

                    $torrent->setState(TorrentState::COMPLETED);
					$this->renamerLogger->debug("[RENAMING] Completing renaming process for torrent $torrentName with hash $hash -- COMPLETED");
					$this->monitorLogger->info("[WORKFLOW-FINISHED] COMPLETED processing $torrentName");
					$this->processManager->killWorkerProcessesIfRunning();
				}

				$this->update($torrent);

				if (!$alreadyCleared) {
					$this->clearTorrentFromTransmissionIfSuccessful($torrent);
				}

		} else {
			// Not found in DB
			$this->renamerLogger->warn("[RENAMING] Torrent not found in DB with expected state: $hash, current state is " . $torrent->getState());
		}
	}

	private function countNumberOfOccurrencesOfHash($originalPathList, $hash) {

		$ocurrences = 0;
		foreach($originalPathList as $path) {
			$ocurrences = $ocurrences + substr_count($path, $hash);
		}

		return $ocurrences;
	}

	private function areSubtitlesPresentForRenamedPath($renamedPath) {

		$res = true;

		$renamedPathsArray = explode(";",$renamedPath);

		if (count($renamedPathsArray) > 1) {

			// Multiple paths per torrent, check if any is missing
			foreach ($renamedPathsArray as $path) {
				$res = $res && $this->checkSubtitlesPresenceForPath($path);
			}

			return $res;
			
		} else { 
			// Regular case, 1 path per torrent
			return $this->checkSubtitlesPresenceForPath($renamedPath);
		}
	}
	
	/** Filebot uses 3-letters language code, our script generates the others */
	private function checkSubtitlesPresenceForPath($path) {

		$subtitleLanguagesToCheck = array("eng","spa");
		$pathInfo = pathinfo($path);

		$baseFilename = $pathInfo['filename'];
		$dirname = $pathInfo['dirname'];

		foreach ($subtitleLanguagesToCheck as $lang) {
			$subtitleFilename =  $dirname . "/" .$baseFilename . ".$lang." . "srt";
			$this->renamerLogger->debug("[SUBTITLES-CHECK] Checking file $subtitleFilename");
			if (!file_exists($subtitleFilename)) {
				$this->renamerLogger->warn("[SUBTITLES-CHECK] $subtitleFilename does not exist");
				return false;
			}
		}

		return true;
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

}
