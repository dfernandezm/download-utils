<?php
namespace Morenware\DutilsBundle\Service;
use Doctrine\Common\Collections\ArrayCollection;

use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;
use Monolog\Logger;
use Morenware\DutilsBundle\Entity\AutomatedSearchConfig;

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

        $this->transactionService->executeInTransactionWithRetryUsingProvidedEm($this->em, function() use ($automatedSearchConfig) {
            $this->linkFeedsToAutomatedSearch($automatedSearchConfig);
            $this->em->persist($automatedSearchConfig);
        });
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
        foreach ($feedIds as $feedId) {
            $feed = $this->torrentFeedService->find($feedId);
            $toAdd[] = $feed;
        }

        // To delete
        foreach ($currentFeeds as $currentFeed) {
            if (!in_array($currentFeed, $toAdd)) {
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

    /** Non implicit transaction, needs one */
    public function merge($automatedSearchConfig) {
        $this->em->merge($automatedSearchConfig);
    }

    /* Implicit transaction version */
    public function update($automatedSearchConfig) {

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

                $torrents = $this->torrentFeedService->parseAutomatedSearchConfigToTorrents($automatedSearch);

                if (count($torrents) > 0) {

                    if ($automatedSearch->getDownloadStartsAutomatically()) {
                        $this->logger->info("[AUTOMATED-SEARCH] Created " . count($torrents) . " torrents from automated search " . $automatedSearch->getContentTitle() . " to start immediately");
                        $this->startDownloadingOrCreateTorrents($torrents, true);
                    } else {
                        $this->logger->info("[AUTOMATED-SEARCH] Created " . count($torrents) . " torrents from automated search " . $automatedSearch->getContentTitle() . " to keep in AWAITING_DOWNLOAD");
                        $this->startDownloadingOrCreateTorrents($torrents, false);
                    }

                    $automatedSearch->setReferenceDate(new \DateTime());
                    $automatedSearch->setLastDownloadDate(new \DateTime());
                    $this->logger->info("[AUTOMATED-SEARCH] Last checked date outside is " . $automatedSearch->getLastCheckedDate()->format("Y-m-d H:i"));
                }


                $this->update($automatedSearch);

            } catch (\Exception $e) {
                $this->renamerLogger->error("[AUTOMATED-SEARCH] Error retrieving data from Automated Search " . $automatedSearch->getContentTitle() . " == " . $e->getMessage() . " \n == " . $e->getTraceAsString());
            }
        }
    }

    private function startDownloadingOrCreateTorrents($torrents, $startDownload) {

        if ($startDownload) {
            foreach($torrents as $torrent) {
                $this->renamerLogger->debug("[AUTOMATED-SEARCH] Starting immediate download for torrent " . $torrent->getTitle());
                $this->torrentService->startTorrentDownload($torrent);
                sleep(1);
            }
        } else {

            foreach($torrents as $torrent) {
                $this->renamerLogger->debug("[AUTOMATED-SEARCH] Persisting torrent in AWAITING_DOWNLOAD state " . $torrent->getTitle());
                $this->torrentService->create($torrent);
            }
        }

    }

}