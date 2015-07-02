<?php
namespace Morenware\DutilsBundle\Service;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\Common\Persistence\ObjectManager;
use Monolog\Logger;
use Morenware\DutilsBundle\Entity\AutomatedSearchConfig;
use Morenware\DutilsBundle\Entity\MediaContentQuality;
use Morenware\DutilsBundle\Entity\Torrent;
use Morenware\DutilsBundle\Entity\TorrentOrigin;
use Morenware\DutilsBundle\Entity\TorrentContentType;
use Morenware\DutilsBundle\Entity\TorrentState;
use Morenware\DutilsBundle\Entity\Feed;
use Morenware\DutilsBundle\Util\GuidGenerator;

/** @Service("torrentfeed.service") */
class TorrentFeedService
{

    /** @DI\Inject("doctrine.orm.entity_manager")
     *  @var \Doctrine\ORM\EntityManager $em
     */
    public $em;

    /** @var \Doctrine\ORM\EntityRepository $repository */
    private $repository;

    private $entityClass;

    private $logger;

    private $debrilFeedReader;

    /** @DI\Inject("torrent.service") */
    public $torrentService;

    /** @DI\Inject("transmission.service") */
    public $transmissionService;


    /**
     * @DI\InjectParams({
     *    "renamerLogger"	 = @DI\Inject("monolog.logger.renamer"),
     *    "debrilFeedReader" = @DI\Inject("debril.reader"),
     *    "entityClass"      = @DI\Inject("%morenware_dutils.torrentfeed.class%")
     * })
     *
     */
    public function __construct(Logger $renamerLogger, $debrilFeedReader, $entityClass)
    {

        $this->logger = $renamerLogger;
        $this->debrilFeedReader = $debrilFeedReader;
        $this->entityClass = $entityClass;
    }

    public function getRepository()
    {

        if ($this->repository == null) {
            $this->repository = $this->em->getRepository($this->entityClass);
        }

        return $this->repository;
    }

    public function create($feed)
    {
        $this->em->persist($feed);
        $this->em->flush();
    }

    public function merge($feed)
    {
        $this->em->merge($feed);
    }

    public function update($feed)
    {
        $this->em->merge($feed);
        $this->em->flush();
    }

    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    public function delete($feedId)
    {
        $feed = $this->find($feedId);
        $this->em->remove($feed);
        $this->em->flush();
    }

    public function findFeedsForAutomatedSearch($feedsTitle) {
        $feeds = $this->getRepository()->findBy(array('description' => $feedsTitle, 'active' => true));
        $this->em->flush();
        $this->em->clear();
        return $feeds;
    }


    public function checkFeedsForTorrents()
    {

        // list all feeds
        // - get XML into entities
        // - loop checking dates
        // - generate Torrent entities with state AWAITING_DOWNLOAD
        // execute this as cron -- every day at 2:00 AM

        $feeds = $this->getAll();

        foreach ($feeds as $feed) {

            if ($feed->getActive()) {

                $this->logger->info("Reading active feed " . $feed->getDescription());
                // Check each feed in a separate transaction
                $this->em->transactional(function ($em) use ($feed) {

                    try {
                        $torrents = $this->parseFeedContentToTorrents($feed);
                    } catch (\Exception $e) {
                        $this->logger->warn("We assume there is an error in the feed -- continue with next feed" . $e->getMessage() . " \n" . $e->getTraceAsString());
                        //continue;
                    }

                    foreach ($torrents as $torrent) {
                        $this->torrentService->create($torrent);
                        $this->logger->info("Sending torrent " . $torrent->getGuid() . " torrents from feed " . $feed->getDescription() . " to Transmission for download");
                        $this->transmissionService->startDownload($torrent);
                    }

                });
            }
        }

    }


    public function parseFeedContentToTorrents($feed)
    {

        $this->logger->info("Parsing feed with URL " . $feed->getUrl());

        $lastDownloadDate = $feed->getLastDownloadDate();

        $referenceDate = $lastDownloadDate != null ? $lastDownloadDate : new \DateTime();

        $feedResult = $this->debrilFeedReader->getFeedContent($feed->getUrl(), $referenceDate);

        $readItems = $feedResult->getItems();

        $titles = array();
        $torrents = array();

        // Regardless of existence of torrents to download or not, we are checking the feed, so we set the lastCheckedDate to now
        $feed->setLastCheckedDate(new \DateTime());

        foreach ($readItems as $item) {

            $torrent = new Torrent();
            $torrent->setTitle((string)$item->getTitle());
            $torrent->setMagnetLink((string)$item->getLink());
            $torrent->setOrigin(TorrentOrigin::FEED);
            $torrent->setContentType(TorrentContentType::TV_SHOW);
            $torrent->setState(TorrentState::AWAITING_DOWNLOAD);
            $torrent->setDate($item->getUpdated());
            $torrent->setGuid(GuidGenerator::generate());

            $torrentTitle = $torrent->getTitle();

            //TODO: Take into account 1080p
            $currentIsHD = strpos($torrentTitle, '720p') !== false;
            $titleNoQuality = str_replace("720p", "", $torrentTitle);
            $titleToSearch = trim(strtolower(str_replace(" ", "", $titleNoQuality)));
            $key = array_search($titleToSearch, $titles);

            if ($key !== false) { // title has already been added

                if ($currentIsHD) { // replace if current is HD
                    $previous = $torrents[$key];
                    $torrents[$key] = $torrent;
                    $this->logger->debug("Replaced torrent " . $previous->getTitle() . " with " . $torrent->getTitle());
                }

            } else { // no added so add it now
                $torrents[] = $torrent;
                $titles[] = $titleToSearch;
                $this->logger->debug("Added torrent " . $torrent->getTitle());
            }
        }

        $this->logger->info("Created " . count($torrents) . " torrents from feed " . $feed->getDescription() . " awaiting download");

        if (count($torrents) > 0) {
            // There are torrents to download, set lastDownloadDate to now
            $feed->setLastDownloadDate(new \DateTime());
        }

        //TODO: only update if the Transmission Download started correctly
        $this->merge($feed);

        return $torrents;
    }


    public function parseAutomatedSearchConfigToTorrents(AutomatedSearchConfig $automatedSearchConfig) {

        //$feeds = $this->findFeedsForAutomatedSearch($automatedSearchConfig->getContentTitle());
        $feeds = $automatedSearchConfig->getFeeds();
        $torrents = array();
        $titles = array();
        $automatedSearchConfig->setLastCheckedDate(new \DateTime());
        $this->logger->info("[AUTOMATED-SEARCH] Last checked date is  " . $automatedSearchConfig->getLastCheckedDate()->format("Y-m-d H:i"));

        /** @var \Morenware\DutilsBundle\Entity\Feed $feed */
        foreach ($feeds as $feed) {
            try {
                $this->logger->info("[AUTOMATED-SEARCH] Parsing feed with URL " . $feed->getUrl());

                $lastDownloadDate = $feed->getLastDownloadDate();

                $referenceDate = $lastDownloadDate != null ? $lastDownloadDate : $automatedSearchConfig->getReferenceDate();

                $feedResult = $this->debrilFeedReader->getFeedContent($feed->getUrl(), $referenceDate);

                $readItems = $feedResult->getItems();

                // Regardless of existence of torrents to download or not, we are checking the feed, so we set the lastCheckedDate to now
                $feed->setLastCheckedDate(new \DateTime());

                foreach ($readItems as $item) {

                    $torrent = new Torrent();
                    $torrent->setTitle((string)$item->getTitle());
                    $torrent->setTorrentName((string)$item->getTitle());
                    $torrent->setMagnetLink((string)$item->getLink());
                    $torrent->setOrigin(TorrentOrigin::FEED);
                    $torrent->setContentType(TorrentContentType::TV_SHOW);
                    $torrent->setState(TorrentState::AWAITING_DOWNLOAD);
                    $torrent->setDate($item->getUpdated());
                    $torrent->setGuid(GuidGenerator::generate());

                    $torrentTitle = $torrent->getTitle();

                    $currentIsHD = strpos($torrentTitle, '720p') !== false;
                    $titleNoQuality = str_replace("720p", "", $torrentTitle);
                    $titleToSearch = trim(strtolower(str_replace(" ", "", $titleNoQuality)));
                    $key = array_search($titleToSearch, $titles);

                    if ($key !== false) { // title has already been added

                        if ($currentIsHD && $automatedSearchConfig->getPreferredQuality() == MediaContentQuality::P720) { // replace if current is HD
                            $previous = $torrents[$key];
                            $torrents[$key] = $torrent;
                            $this->logger->debug("[AUTOMATED-SEARCH] Replaced torrent " . $previous->getTitle() . " with " . $torrent->getTitle());
                        }

                    } else { // no added so add it now
                        $torrents[] = $torrent;
                        $titles[] = $titleToSearch;
                        $this->logger->debug("[AUTOMATED-SEARCH] Adding torrent " . $torrent->getTitle());
                    }
                }

                $this->logger->info("[AUTOMATED-SEARCH] Created " . count($torrents) . " torrents from feed " . $feed->getDescription());

                $this->merge($feed);

            } catch (\Exception $e) {
                $this->logger->info("[AUTOMATED-SEARCH] Error occurred checking feed  " . $feed->getDescription() . " " . $e->getMessage() . $e->getMessage() . " \n" . $e->getTraceAsString() . "\n == continue with next feed");
            }
        }

        return $torrents;
    }


}





















