<?php
namespace Morenware\DutilsBundle\Service;
use Doctrine\Common\Collections\ArrayCollection;

use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;
use Monolog\Logger;
use Morenware\DutilsBundle\Entity\AutomatedSearchConfig;
use Morenware\DutilsBundle\Entity\MediaContentQuality;
use Morenware\DutilsBundle\Entity\TorrentContentType;
use Morenware\DutilsBundle\Util\GeneralUtils;

/** @Service("automatedsearch.service") */
class AutomatedSearchService {

    /** @DI\Inject("doctrine.orm.entity_manager")
     *  @var \Doctrine\ORM\EntityManager $em
     */
    public $em;

    /** @var \Doctrine\ORM\EntityRepository $repository */
    private $repository;
    private $entityClass;
    private $renamerLogger;

    /** @DI\Inject("transaction.service")
     * @var \Morenware\DutilsBundle\Util\TransactionService $transactionService
     */
    public $transactionService;

    /** @DI\Inject("torrentfeed.service")
     * @var \Morenware\DutilsBundle\Service\TorrentFeedService $torrentFeedService
     */
    public $torrentFeedService;

    /** @DI\Inject("torrent.service")
     *  @var \Morenware\DutilsBundle\Service\TorrentService $torrentService
     */
    public $torrentService;

    /**
     * @DI\InjectParams({
     *     "logger"           = @DI\Inject("monolog.logger"),
     *     "renamerLogger"	 = @DI\Inject("monolog.logger.renamer"),
     *     "entityClass"      = @DI\Inject("%morenware_dutils.automatedsearchconfig.class%")
     * })
     *
     */
    public function __construct(Logger $logger, Logger $renamerLogger, $entityClass) {

        $this->logger = $logger;
        $this->renamerLogger = $renamerLogger;
        $this->entityClass = $entityClass;
    }


    public function getRepository() {

        if ($this->repository == null) {
            $this->repository = $this->em->getRepository($this->entityClass);
        }

        return $this->repository;
    }

    public function create($automatedSearchConfig) {
        $this->attachFeedsForTvShowAutomatedSearch($automatedSearchConfig);
        $this->transactionService->executeInTransactionWithRetryUsingProvidedEm($this->em, function() use ($automatedSearchConfig) {
            $this->linkFeedsToAutomatedSearch($automatedSearchConfig);
            $this->em->persist($automatedSearchConfig);
        });
    }


    /**
     * Simple matching of feeds based on the name of the TV Show
     *
     * @param AutomatedSearchConfig $automatedSearch
     */
    public function attachFeedsForTvShowAutomatedSearch(AutomatedSearchConfig $automatedSearch) {

        if ($automatedSearch->getContentType() === TorrentContentType::TV_SHOW) {

            $tvShowName = $automatedSearch->getContentTitle();
            $feeds = $this->torrentFeedService->findFeedsForAutomatedSearch($tvShowName);

            $feedIds = array();

            foreach ($feeds as $feed) {
                 $this->logger->info("[AUTOMATED-SEARCH] Attaching feed " . $feed->getDescription() ." to automated search being created");
                 $feedIds[] = $feed->getId();
            }

            $automatedSearch->setFeedIds($feedIds);
        }
    }


    private function linkFeedsToAutomatedSearch(AutomatedSearchConfig $automatedSearchConfig) {

        $feedIds = $automatedSearchConfig->getFeedIds();
        $currentFeeds = new ArrayCollection();

        // Get current feeds if they exist
        if ($automatedSearchConfig->getId() !== null) {
            $currentAutomatedSearchConfig = $this->find($automatedSearchConfig->getId());
            $currentFeeds =  $currentAutomatedSearchConfig->getFeeds();
        }

        // Initialize feeds collection
        if ($automatedSearchConfig->getFeeds() == null) {
            $automatedSearchConfig->setFeeds(new ArrayCollection());
        } else {
            $automatedSearchConfig->setFeeds($currentFeeds);
        }

        $toAdd = array();

        // Extract feeds to add from ids
        if ($feedIds != null) {
            foreach ($feedIds as $feedId) {
                $feed = $this->torrentFeedService->find($feedId);
                $toAdd[] = $feed;
            }
        }

        // To delete
        foreach ($currentFeeds as $currentFeed) {
            if (!in_array($currentFeed, $toAdd)) {
                // Need to do both ways
                $automatedSearchConfig->getFeeds()->removeElement($currentFeed);
                $currentFeed->setAutomatedSearchConfig(null);
            }
        }

        // To add
        if (count($feedIds) > 0) {
            foreach ($feedIds as $feedId) {
                $feed = $this->torrentFeedService->find($feedId);
                $automatedSearchConfig->getFeeds()->add($feed);
                $feed->setAutomatedSearchConfig($automatedSearchConfig);
            }
        }

    }


    public function persist($automatedSearchConfig) {
        $this->em->persist($automatedSearchConfig);
    }

    /** Non implicit transaction, needs one
     * @param $automatedSearchConfig
     */
    public function merge($automatedSearchConfig) {
        $this->em->merge($automatedSearchConfig);
        return $automatedSearchConfig;
    }

    /* Implicit transaction version */
    public function update($automatedSearchConfig) {

        //if ($attachFeeds) {
            $this->attachFeedsForTvShowAutomatedSearch($automatedSearchConfig);
        //}

        $this->transactionService->executeInTransactionWithRetryUsingProvidedEm($this->em, function() use ($automatedSearchConfig) {
            $this->linkFeedsToAutomatedSearch($automatedSearchConfig);
            $this->em->merge($automatedSearchConfig);
        });

    }

    public function find($id) {
        return $this->em->find($this->entityClass, $id);
    }

    public function getAll() {
        return $this->getRepository()->findAll();
    }

    public function getAllOrderedByDate() {
        return $this->getRepository()->findBy(array(), array('lastCheckedDate' => 'DESC'));
    }

    public function delete($automatedSearchConfig) {
        $this->em->remove($automatedSearchConfig);
        $this->em->flush();
        $this->em->clear();
    }

    public function findActiveAutomatedSearchsToRun() {

        $todayDate = new \DateTime();

        $q = $this->em->createQuery("select asearch from MorenwareDutilsBundle:AutomatedSearchConfig asearch " .
            "where asearch.active =  true AND (asearch.lastCheckedDate is null OR asearch.lastCheckedDate < :todayDate)")
            ->setParameter("todayDate", $todayDate->format("Y-m-d H:i"));
        $automatedSearchs = $q->getResult();
        return $automatedSearchs;
    }

    public function executeAutomatedSearchs() {

        $automatedSearchs = $this->findActiveAutomatedSearchsToRun();

        /** @var \Morenware\DutilsBundle\Entity\AutomatedSearchConfig $automatedSearch */
        foreach ($automatedSearchs as $automatedSearch) {

            try {

                $this->renamerLogger->info("[AUTOMATED-SEARCH] Checking automated search for " . $automatedSearch->getContentTitle());
                $this->transactionService->executeInTransactionWithRetryUsingProvidedEm($this->em, function() use ($automatedSearch) {

                    $torrents = $this->torrentFeedService->parseAutomatedSearchConfigToTorrents($automatedSearch);

                    $torrents = $this->filterTorrentsAccordingToQuality($automatedSearch, $torrents);

                    // Regardless of torrents being found, we update the last time this was checked
                    $automatedSearch->setReferenceDate(new \DateTime());
                    $automatedSearch->setLastCheckedDate(new \DateTime());

                    $this->renamerLogger->info("[AUTOMATED-SEARCH] Setting last checked date to " . $automatedSearch->getLastCheckedDate()->format("Y-m-d H:i"));

                    if (count($torrents) > 0) {

                        $automatedSearch->setLastDownloadDate(new \DateTime());

                        if ($automatedSearch->getDownloadStartsAutomatically()) {
                            $this->renamerLogger->info("[AUTOMATED-SEARCH] Created " . count($torrents) . " torrents from automated search " . $automatedSearch->getContentTitle() . " to start immediately");
                            $this->startDownloadingOrCreateTorrents($torrents, $automatedSearch, true);
                        } else {
                            $this->renamerLogger->info("[AUTOMATED-SEARCH] Created " . count($torrents) . " torrents from automated search " . $automatedSearch->getContentTitle() . " to keep in AWAITING_DOWNLOAD");
                            $this->startDownloadingOrCreateTorrents($torrents, $automatedSearch, false);
                        }

                        // There are torrents found, so lastDownloadDate is updated
                        $this->renamerLogger->info("[AUTOMATED-SEARCH] Last download date is " . $automatedSearch->getLastDownloadDate()->format("Y-m-d H:i"));
                    }

                    // Need to merge to update
                    $this->merge($automatedSearch);
            });

            } catch (\Exception $e) {
                $this->renamerLogger->error("[AUTOMATED-SEARCH] Error retrieving data from Automated Search " . $automatedSearch->getContentTitle() . " == " . $e->getMessage() . " \n == " . $e->getTraceAsString());
            }
        }
    }

    private function startDownloadingOrCreateTorrents($torrents, $automatedSearch, $startDownload) {

        if ($startDownload) {
            foreach($torrents as $torrent) {
                $this->renamerLogger->debug("[AUTOMATED-SEARCH] Starting immediate download for torrent " . $torrent->getTitle());
                $torrent->setAutomatedSearchConfig($automatedSearch);
                $this->torrentService->startTorrentDownload($torrent);

                // Sleep 1 second between calls to transmission
                sleep(1);
            }
        } else {

            foreach($torrents as $torrent) {
                $this->renamerLogger->debug("[AUTOMATED-SEARCH] Persisting torrent in AWAITING_DOWNLOAD state " . $torrent->getTitle());
                $torrent->setAutomatedSearchConfig($automatedSearch);

                // IMPORTANT: Doctrine: We use merge() instead of persist() here because we are setting an
                // ALREADY existing entity ($automatedSearch) into a new one ($torrent). If we call persist() it is going
                // to complain due to a new unknown entity ($automatedSearch) even though we merged it before this call.

                $this->torrentService->merge($torrent);
            }
        }

    }

    private function filterTorrentsAccordingToQuality(AutomatedSearchConfig $automatedSearch, $torrents) {

        // Title to Torrents map
        $seasonAndEpisodeToTorrents = array();
        // Use regex to get the episode number and season - unique in the array of
        $seasonAndEpisodeRegex = '/(.*)([\d]+x[\d]+)(.*)/';

        $getInHd = $automatedSearch->getPreferredQuality() == MediaContentQuality::P720;

        // We only want one title - one torrent => so we don't download duplicates or different qualities
        foreach ($torrents as $torrent) {

            $title = $torrent->getTitle();
            $matches = array();

            $this->renamerLogger->debug("[AUTOMATED-SEARCH] Filtering torrent $title");

            if (preg_match($seasonAndEpisodeRegex,$title, $matches)) {

                // 0 is everything, 1 is first group (series name), 2 is season and episode, 3 is the rest
                $seasonAndEpisode = $matches[2];

                if (strpos($title, '720p') !== false && $getInHd) {

                    $this->renamerLogger->debug("[AUTOMATED-SEARCH] Adding torrent, overriding as 720p is required [$seasonAndEpisode => $title]");

                    // Override directly
                    $seasonAndEpisodeToTorrents[$seasonAndEpisode] = $torrent;
                } else {

                    $this->renamerLogger->debug("[AUTOMATED-SEARCH] It is not a 720p torrent or 720p not required -- $title");

                    if (!array_key_exists($seasonAndEpisode, $seasonAndEpisodeToTorrents)) {

                        $this->renamerLogger->debug("[AUTOMATED-SEARCH] Adding torrent, it was not previous torrent for [$seasonAndEpisode => $title] -- adding it now");

                        // There is no torrent yet, add it
                        $seasonAndEpisodeToTorrents[$seasonAndEpisode] = $torrent;
                    }

                    // Else, we do not override, a torrent is already present
                }
            }
        }

        $torrentsToDownload = array_values($seasonAndEpisodeToTorrents);

        // Final filter [REFACTOR]
        $finalTorrents = array();

        foreach ($torrentsToDownload as $torrent) {

            $magnetLink = $torrent->getMagnetLink();
            $hash = $this->torrentService->extractHashFromMagnetLink($magnetLink);

            if ($hash !== null) {
                $existingTorrent = $this->torrentService->findByHashIsolated($hash);
                if ($existingTorrent == null) {
                    $finalTorrents[] = $torrent;
                } else {
                    $this->renamerLogger->info("[AUTOMATED-SEARCH] Torrent already exists in DB -- skipping " . $torrent->getTitle() . " [$hash]");
                }
            } else {
                $this->renamerLogger->info("[AUTOMATED-SEARCH] Unable to extract torrent from magnet link, assume it is invalid  -- $magnetLink -- " . $torrent->getTitle());
            }
        }

        $this->renamerLogger->debug("[AUTOMATED-SEARCH] Filtered to " . count($finalTorrents) . " torrents");
        return $finalTorrents;
    }

}