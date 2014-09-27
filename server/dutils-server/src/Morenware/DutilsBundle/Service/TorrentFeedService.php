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

/** @Service("torrentfeed.service") */
class TorrentFeedService {

	/** @DI\Inject("doctrine.orm.entity_manager") */
	public $em;
	
	private $repository;

	private $entityClass;
	
	private $logger;
	
	private $debrilFeedReader;

   
   /**
	* @DI\InjectParams({
	*     "logger"           = @DI\Inject("logger"),
	*     "debrilFeedReader" = @DI\Inject("debril.reader"),
	*     "entityClass"      = @DI\Inject("%morenware_dutils.torrentfeed.class%")
	* })
	*
	*/
	public function __construct($logger, $debrilFeedReader, $entityClass) {

		$this->logger = $logger;
		$this->debrilFeedReader = $debrilFeedReader;
		$this->entityClass = $entityClass;
	}
	
	public function getRepository() {
		
		if ($this->repository == null) {
			$this->repository = $this->em->getRepository($this->entityClass);
		}
		
		return $this->repository;
	}
	
	public function createFeed($feed) {
		$this->em->persist($feed);
		$this->em->flush();
	}
	
	public function mergeFeed($feed) {
		$this->em->merge($feed);
		$this->em->flush();
	}
	
	public function findFeed($id) {
		return $this->em->find($id);
	}	
	
	public function getAllFeeds() {
		return $this->repository->findAll();
	}
	
	public function deleteFeed($feedId) {
		$feed = $this->findFeed($feedId);
		$this->em->remove($feed);
		$this->em->flush();
	}

	
	public function checkFeedsForTorrents() {

		// list all feeds
		// get XML into entities
		// loop checking dates
		// generate Torrent entities with state AWAITING_DOWNLOAD
		// execute this as cron -- every day at 2:00 AM
		
		$feed = new Feed();
		
		$feed->setUrl("http://showrss.info/feeds/885.rss");
		$feed->setDescription("ShowRSS - The Strain");
		$feed->setLastCheckedDate(new \DateTime());
		
		$lastDownloadDate = new \DateTime('05-Sep-2014');
		
		$feed->setLastDownloadDate($lastDownloadDate);
		
		$torrents = $this->parseFeedContentToTorrents($feed);
		
		//TODO: persist torrents in DB
		
		//TODO: Generate downloads: download jobs and call transmission with them
		$this->generateDownloadsForParsedFeed($feed, $torrents);
	}
	
	
	public function parseFeedContentToTorrents($feed) {
		
		$this->logger->info("Parsing feed ".$feed->getUrl());
		
		$lastDownloadDate = $feed->getLastDownloadDate();
		
		$referenceDate = $lastDownloadDate != null ? $lastDownloadDate : new \DateTime();
		
		$feedResult = $this->debrilFeedReader->getFeedContent($feed->getUrl(), $referenceDate);

		$readItems = $feedResult->getItems();
		
		$titles = array();
		$torrents = array();
	
		foreach ($readItems as $item) {
			
			$torrent = new Torrent();
			$torrent->setTitle((string) $item->getTitle());
			$torrent->setMagnetLink((string) $item->getLink());
			$torrent->setOrigin(TorrentOrigin::FEED);
			$torrent->setContentType(TorrentContentType::TV_SHOW);
			$torrent->setState(TorrentState::AWAITING_DOWNLOAD);
			$torrent->setDate($item->getUpdated());
		
			$torrentTitle = $torrent->getTitle();
			$currentIsHD = strpos($torrentTitle, '720p') !== false;
			$titleNoQuality = str_replace("720p", "", $torrentTitle);
			$titleToSearch = trim(strtolower(str_replace(" ", "", $titleNoQuality))); 			
			$key = array_search($titleToSearch, $titles);
			
			if ($key !== false) { // title has already been added
				
				if ($currentIsHD) { // replace if current is HD
					$previous = $torrents[$key];
					$torrents[$key] = $torrent;
					$this->logger->debug("Replaced torrent ".$previous->getTitle()." with ".$torrent->getTitle());
				}
				
			} else { // no added so add it now
				$torrents[] = $torrent;
				$titles[] = $titleToSearch;
				$this->logger->debug("Added torrent ".$torrent->getTitle());
			}
		}
				
		$this->logger->info("Created ". count($torrents) ." torrents from feed ".$feed->getDescription());
		
		return $torrents;
	}
	
	
	public function generateDownloadsForParsedFeed($feed, $torrents) {
		// Call transmission to start the downloads
			// Generate download jobs referencing the torrents
		// When transmission acknowledges, change the state of torrents to DOWNLOADING
		// Update the lastDownloadDate of the feed to NOW
	}
	
	
	
	
	
	
}