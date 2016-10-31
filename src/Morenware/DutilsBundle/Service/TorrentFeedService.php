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

    public function update($feed) {
        $this->em->merge($feed);
        $this->em->flush();
    }

    public function find($id) {
        return $this->getRepository()->find($id);
    }

    public function getAll() {
        return $this->getRepository()->findAll();
    }

    public function delete($feedId) {
        $feed = $this->find($feedId);
        $this->em->remove($feed);
        $this->em->flush();
    }

    public function findFeedsForAutomatedSearch($feedsTitle) {

        $q = $this->em->createQuery(
            "select f from MorenwareDutilsBundle:Feed f " .
            "where LOWER(f.description) = :title")
            ->setParameter("title", strtolower($feedsTitle));
        $feeds = $q->getResult();

        return $feeds;
    }

    public function parseAutomatedSearchConfigToTorrents(AutomatedSearchConfig $automatedSearchConfig) {

        $feeds = $automatedSearchConfig->getFeeds();
        $torrents = array();
        $automatedSearchConfig->setLastCheckedDate(new \DateTime());
        $this->logger->info("[AUTOMATED-SEARCH] Last checked date is  " . $automatedSearchConfig->getLastCheckedDate()->format("Y-m-d H:i"));

        /** @var \Morenware\DutilsBundle\Entity\Feed $feed */
        foreach ($feeds as $feed) {

            try {

                $this->logger->info("[AUTOMATED-SEARCH] Checking feed with URL " . $feed->getUrl());

                $referenceDate = $automatedSearchConfig->getReferenceDate();

                $this->logger->info("[AUTOMATED-SEARCH] Initial reference date is  " . $automatedSearchConfig->getReferenceDate()->format("Y-m-d H:i"));

                $feedResult = $this->debrilFeedReader->getFeedContent($feed->getUrl(), $referenceDate);

                $readItems = $feedResult->getItems();

                foreach ($readItems as $item) {

                    $torrent = new Torrent();
                    $torrent->setTitle((string)$item->getTitle());
                    $torrent->setTorrentName((string)$item->getTitle());

                    $magnetLink = (string)$item->getLink();

                    $torrent->setMagnetLink($magnetLink);
                    $torrent->setOrigin(TorrentOrigin::FEED);
                    $torrent->setContentType(TorrentContentType::TV_SHOW);
                    $torrent->setState(TorrentState::AWAITING_DOWNLOAD);
                    $torrent->setDate($item->getUpdated());
                    $torrent->setGuid(GuidGenerator::generate());

                    $hash = $this->torrentService->extractHashFromMagnetLink($magnetLink);
                    $this->logger->info("[AUTOMATED-SEARCH] Found torrent in feed: " . $torrent->getTitle() . " [$hash]");
                    $torrents[] = $torrent;

                }

                $this->logger->info("[AUTOMATED-SEARCH] Found " . count($torrents) . " torrents from feed " . $feed->getDescription());

            } catch (\Exception $e) {
                $this->logger->info("[AUTOMATED-SEARCH] Error occurred checking feed  " . $feed->getDescription() . " " . $e->getMessage() . " \n" . $e->getTraceAsString() . "\n == continue with next feed");
            }
        }

        return $torrents;
    }
}





















