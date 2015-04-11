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
use Symfony\Component\DomCrawler\Crawler;

/** @Service("search.service") */
class SearchTorrentsService {

	private $logger;
	
	/** @DI\Inject("transmission.service") */
	public $transmissionService;
	
	/** @DI\Inject("torrent.service") */
	public $torrentService;
	
	/**
	 * @DI\Inject("%torrents_temp_path%")
	 */
	public $torrentsTempPath;
	
	/**
	 * @DI\Inject("%search_cache_dir%")
	 */
	public $searchCacheDir;
	

	const MAIN_SECTION = "MAIN";
	const DETAIL_SECTION = "DETAIL";
	const DIVX_TOTAL_ID = "DT";
	const KICKASS_TORRENTS_ID = "KT";
	
	const AGE_DAY = "day";
	const AGE_WEEK = "week";
	const AGE_HOUR = "hour";
	const AGE_MONTH = "month";
	const AGE_YEAR = "year";
	
	
   /**
	* @DI\InjectParams({
	*     "logger"  = @DI\Inject("logger")
	* })
	*
	*/
	public function __construct($logger) {

		$this->logger = $logger;
	}
	
	public function searchTorrentsInWebsites($searchQuery, $websitesToSearch, $limit = 25, $offset = 0) {
		
		// We need to paginate results here as the search could retrieves the whole series in a single page
		$torrents = array();
		
		foreach ($websitesToSearch as $websiteId) {

			if ($websiteId === self::KICKASS_TORRENTS_ID) {
				$torrents = $torrents + $this->searchKickassTorrents($searchQuery);
			}
			
			if ($websiteId === self::DIVX_TOTAL_ID) {
				$torrents = $torrents + $this->searchDivxTotal($searchQuery);
			}
		}
			
		return $torrents;
	}
	
	public function searchDivxTotal($searchQuery, $limit = 1000, $offset = 0) {
		
		$baseUrl = "http://www.divxtotal.com";
		$limit = 25;
		$offset = 0;
		$searchQuery = urlencode($searchQuery);
		
		// Sort by date
		$mainUrl = $baseUrl . "/buscar.php?busqueda=" . $searchQuery . "&orden=1";
		$innerPageLinkPattern = '/href="(\/series\/[^\s"]+)/';

		$moreThanOnePagePattern = '/href="(buscar\.php\?busqueda=[^"]+)&pagina=([0-9])"/';
		
		$resultsPageHtml = $this->getFromCache(self::DIVX_TOTAL_ID, self::MAIN_SECTION, $searchQuery);
		
		if ($resultsPageHtml == null) {
			$this->logger->debug("Cache miss, connecting to website and caching");
			$resultsPageHtml = file_get_contents($mainUrl);
			$this->writeCacheFile(self::DIVX_TOTAL_ID, self::MAIN_SECTION, $searchQuery, $resultsPageHtml);
		} else {
			$this->logger->debug("Cache hit, getting cached content");
		}
		
	
		$torrents = array();
		$torrentNames = array();
		$total = 0;
		$currentOffset = $offset;
		
		$matches = array();
		
		$this->logger->debug("The complete url is $mainUrl to search is ".$searchQuery);
		
		list($hasMoreThanOne, $numPages) = $this->hasMoreThanOnePageDivxTotal($resultsPageHtml, $moreThanOnePagePattern);

		if ($hasMoreThanOne) {
			$this->logger->debug("!! This has $numPages pages of results");
			//TODO: We have to check if there is any movie to resolve its detail page as TV Shows resolve just with one page only
		}
		
		if (preg_match($innerPageLinkPattern, $resultsPageHtml, $matches)) {
		
			$innerLinkForTvShow = $matches[1];
		
			$this->logger->debug("Inner link for TV Show is $baseUrl$innerLinkForTvShow");
		
			$tvShowDetailHtml = $this->getFromCache(self::DIVX_TOTAL_ID, self::DETAIL_SECTION, $searchQuery);
			
			if ($tvShowDetailHtml == null) {
				$this->logger->debug("Cache miss, connecting to website and caching");
				$tvShowDetailHtml = file_get_contents($baseUrl . $innerLinkForTvShow);
				$this->writeCacheFile(self::DIVX_TOTAL_ID, self::DETAIL_SECTION, $searchQuery, $tvShowDetailHtml);
			} else {
				$this->logger->debug("Cache hit, getting cached content");
			}
			
			
			$crawler = new Crawler($tvShowDetailHtml);
			$crawlerRows = $crawler->filter('table.fichserietabla tr');
			
			$episodeNamesAndTorrentLinks = $crawlerRows->filter('tr td.capitulonombre a')->extract(array("_text","href"));
			
			// This can include the "Fecha" headers
			$episodeDate = $crawlerRows->filter('tr td.capitulofecha')->extract(array("_text"));
			
			$total = count($episodeNamesAndTorrentLinks);
			
			if ($total > 0) {

				$this->logger->debug("Total is $total - offset $offset - limit $limit");
				$limit = $limit >= $total ? $total-$offset : $limit;
				$j = $offset;
				for ($i = $offset; $i < ($offset+$limit); $i++) {
		            $episodeNameAndTorrentLink = $episodeNamesAndTorrentLinks[$i];
		            $episodeTitle = $episodeNameAndTorrentLink[0];
		            $torrentFileLink = $episodeNameAndTorrentLink[1];
					$torrentDate = trim($episodeDate[$j]);
					
					// Skip header "Fecha"
					if (strpos($torrentDate, "F") !== false) {
						$j++;
						$torrentDate = trim($episodeDate[$j]);
					}
					
					if (!in_array($episodeTitle, $torrentNames, true)) {
						$torrent = new Torrent();
						$torrent->setTorrentName($episodeTitle);
						$torrentFileLink = $baseUrl . $torrentFileLink;
						$torrent->setTorrentFileLink($torrentFileLink);
						//$this->getQualityFromTorrentFileName($torrentFileLink);
						$date = new \DateTime($torrentDate);
						$torrent->setDate($date);
						$torrent->setState("NEW");
						
						$existingTorrent = $this->torrentService->findTorrentByMagnetOrFile($torrentFileLink);
						
						if ($existingTorrent !== null) {
							$torrent->setState($existingTorrent->getState());
						}
						
						$torrents[] = $torrent;
						$torrentNames[] = $episodeTitle;	
						$this->logger->debug("Adding torrent to the list $episodeTitle");
					}
					
					$j++;
					$this->logger->debug("[DivxTotal] Offset current $episodeTitle ==> $torrentDate ==> " . $date->format('d-m-Y') . " \n");
				}
				
				$currentOffset = $i;
			}
		}
		
		
		return array($torrents, $currentOffset, $total);
	}
	
   public function downloadTorrentToFileAndStart(Torrent $torrent) {
   		
   		$this->logger->debug("Downloading torrent file to  $torrent->getTorrentFileLink() to temporary path");
   		$tempTorrentsPath = $this->torrentsTempPath;
   		$torrentFilename =  $torrent->getTorrentName();
   		$torrentFilePath = "$tempTorrentsPath/$torrentFilename";
   		
   		$torrent->setTorrentFileLink($torrentFilePath);
   		
   		file_put_contents($torrentFilePath, file_get_contents($torrent->getTorrentFileLink())); 		
   		
   		$this->logger->debug("Downloaded torrent file to $torrentFilePath");
   		
   		$this->transmissionService->startDownload($torrent, true);
   		
   }	
   
   
   public function getCacheFilename($websiteId, $section, $searchQuery) {
   	 date_default_timezone_set('UTC');
   	 $date = date("d-m-Y");
   	 $cachePath = $this->searchCacheDir . "/$websiteId";
   	 $normalizedSearchQuery = strtolower(trim($searchQuery));
   	 $baseFileName = base64_encode($section . "-" . $normalizedSearchQuery . "-" . $date);
   	 $path = $cachePath . "/" . $baseFileName . ".cache";
   	 $dir = dirname($path);

   	 if (!file_exists($dir)) {
   	 	mkdir($dir, 0777, true);
   	 }
 
   	 $this->logger->debug("The cache path to check is $path");
   	 return $path;
   }
   
   public function searchKickassTorrents($searchQuery, $limit = 25, $offset = 0) {
     
     $baseUrl = "http://katproxy.com";
     $searchQuery = urlencode($searchQuery);
     $searchUrl = $baseUrl . "/usearch/$searchQuery/?field=time_add&sorder=desc";
     
     $resultsPageHtml = $this->getInitialSearchResultsFromSite(self::KICKASS_TORRENTS_ID, self::MAIN_SECTION, $searchUrl, $searchQuery);
     
     //$orderByFields = array("age", "seed");
     
     $crawler = new Crawler($resultsPageHtml);
     $crawlerRows = $crawler->filter('div table.data tr');

     $total = iterator_count($crawlerRows) - 1; // minus header row
     
     $torrents = array();
     
     if ($total > 1) {
     	
     	$this->logger->debug("[SEARCH-KICKASS] Found $total rows to filter as results");

     	foreach ($crawlerRows as $i => $content) {
			
     		$subCrawler = new Crawler($content);	
     		
     		//$torrentInfoCrawler = $subCrawler->filter("td");
     		
     		$titles = $subCrawler->filter("td div.torrentname div.markeredBlock a.cellMainLink")->extract("_text");
     		$magnetLinks = $subCrawler->filter("td div.iaconbox a.imagnet")->extract("href");
     		// size, files, age, seed, leech
     		$torrentAttributes = $subCrawler->filter("td.center")->extract("_text");
     		
     		$count = count($titles);
     		for ($k = 0; $k < $count; $k++) {
     			$torrent = new Torrent();
     			
     			$torrentName = $titles[$k];
     			$magnetLink = $magnetLinks[$k];
     			
     			$age = $torrentAttributes[2];
     			$date = $this->convertAgeToDate($age);
     			
     			$seeds = $torrentAttributes[3];
     			$this->logger->debug("======== Torrent: $torrentName -- $magnetLink -- Age ". $date->format('Y-m-d H:i:s') . " -- Seed $seeds");
     			$torrent->setTorrentName($torrentName);
     			$torrent->setTitle($torrentName);
     			$torrent->setMagnetLink($magnetLink);
     			$torrent->setDate($date);
     			$torrent->setState("NEW");
     			
     			$existingTorrent = $this->torrentService->findTorrentByMagnetOrFile($magnetLink);
     			
     			if ($existingTorrent !== null) {
     				$torrent->setState($existingTorrent->getState());
     			}
     			
     			$torrents[] = $torrent;
     		}
     	}	
     }
     
     return array($torrents, 25, $total);
     
     //TODO: use the feed link to generate Feed object and then generate torrents!!
     // Example: http://katproxy.com/usearch/better%20call%20saul/?rss=1
   }
   
   private function getInitialSearchResultsFromSite($siteId, $siteSection, $searchUrl, $urlEncodedSearchQuery) {
	   	$resultsPageHtml = $this->getFromCache($siteId, $siteSection, $urlEncodedSearchQuery);
	   	
	   	if ($resultsPageHtml == null) {
	   		$this->logger->debug("Cache miss, connecting to website and caching");
	   		$resultsPageHtml = file_get_contents($searchUrl);
	   		$this->writeCacheFile($siteId, $siteSection, $urlEncodedSearchQuery, $resultsPageHtml);
	   	} else {
	   		$this->logger->debug("Cache hit, getting cached content");
	   	}
	   	
	   	return $resultsPageHtml;
   }
   
   private function convertAgeToDate($ageAsString) {

   		$ageParts = explode(" ",$ageAsString);
   		
   		$number = intval(trim($ageParts[0]));
   		
   		$date = new \DateTime();
   		
   		$intervalString = "";
   		
   		if (strpos($ageAsString, self::AGE_HOUR) !== false) {
   			$intervalString = "-" . $number . " hours"; 
   		} else if (strpos($ageAsString, self::AGE_DAY) !== false) {
   			$intervalString = "-" . $number . " days";
   		} else if (strpos($ageAsString, self::AGE_WEEK) !== false) {
   			$intervalString = "-" . $number . " weeks";
   		} else if (strpos($ageAsString, self::AGE_MONTH) !== false) {
   			$intervalString = "-" . $number . " months";
   		} else if (strpos($ageAsString, self::AGE_YEAR) !== false) {
   			$intervalString = "-" . $number . " years";
   		} 
   		
   		$this->logger->debug("Interval is $intervalString");
   		
   		$interval = \DateInterval::createFromDateString($intervalString);
   
   		$date = $date->add($interval);
   		
   		return $date;		
   }
   
   private function getQualityFromTorrentFileName($torrentFileLink) {
   	//TODO:
   }
    
   public function torrentAlreadyExists($torrentFileNameOrMagnetLink) {
   	$hash = base64_encode($torrentFileNameOrMagnetLink);
   	return $hash;
   }
    
   public function writeCacheFile($websiteId, $section, $searchQuery, $content) {
   	$filename = $this->getCacheFilename($websiteId, $section, $searchQuery);
   	file_put_contents($filename, $content);
   }
    
   public function getFromCache($websiteId, $section, $searchQuery) {
   	$filename = $this->getCacheFilename($websiteId, $section, $searchQuery);
   	if (file_exists($filename)) {
   		$cachedContent = file_get_contents($filename);
   		return $cachedContent;
   	} else {
   		return null;
   	}
   }
   
   public function hasMoreThanOnePageDivxTotal($resultsHtml, $moreThanOnePagePattern) {
   
   	$matches = array();
   
   	if (preg_match_all($moreThanOnePagePattern, $resultsHtml, $matches)) {
   		return array(true, max($matches[2]));
   	} else {
   		return array(false, 0);
   	}
   	
   }
   

   public function searchEliteTorrent($searchQuery, $page = null) {
   
   	$pagination = $page !== null ? "/pag:" . $page : "";
   	$baseUrl = "http://www.elitetorrent.net";
   	$useList = true;
   
   	$listMode = (($useList) ? "/modo:listado" : "");
   
   	$mainUrl = $baseUrl . "/busqueda/" . $searchQuery . $listMode . $pagination;
   
   	//$getTorrentUrlPattern = '/href="(\/get-torrent[^\s"]+)/';
   	$resultsUrlsPattern = '/href="(\/torrent[^\s"]+)/';
   	$torrentMagnetLinkPattern = '/href="(magnet:[^\s"]+)/';
   	$nameAndIdTorrentPattern = '/href="\/torrent\/([0-9]+)\/.*title="([^"]+)/';
   
   
   	$resultsPageHtml = file_get_contents($mainUrl);
   
   	$torrents = array();
   	$torrentNames = array();
   	$matches = array();
   		
   	if($useList) {
   
   		if (preg_match_all($nameAndIdTorrentPattern, $resultsPageHtml, $matches)) {
   
   			$idsList = $matches[1];
   			$namesList = $matches[2];
   
   			for ($i = 0; $i < count($idsList); $i++) {
   
   				$torrentId = $idsList[$i];
   				$torrentName = $namesList[$i];
   
   					
   				if (!in_array($torrentName, $torrentNames, true)) {
   
   					$torrent = new Torrent();
   					$torrent->setTorrentName($torrentName);
   					$torrentFileLink = $baseUrl . "/get-torrent/". $torrentId;
   
   					$torrent->setTorrentFileLink($torrentFileLink);
   					$torrent->setOrigin(TorrentOrigin::SEARCH);
   
   					$torrents[] = $torrent;
   					$torrentNames[] = $torrentNames;
   
   					$this->logger->debug("[EliteTorrent] Getting Torrent $torrentName <==> $torrentFileLink");
   				}
   			}
   		}
   	} else {
   			
   		// We need to navigate to each detail page -- this gives also the magnet link, but it is very slow
   		if (preg_match_all($resultsUrlsPattern, $resultsPageHtml, $matches)) {
   				
   			foreach ($matches[1] as $partialTorrentUrl) {
   					
   				$indexSlash = strrpos($partialTorrentUrl, "/");
   
   				// get Name of torrent
   				$torrentName = substr($partialTorrentUrl, $indexSlash - strlen($partialTorrentUrl) + 1);
   					
   				$torrentDetailUrl = $baseUrl . $partialTorrentUrl;
   					
   				$torrentDetailHtml = file_get_contents($torrentDetailUrl);
   
   				$magnetMatches = array();
   					
   				// Get magnet links
   				if(preg_match($torrentMagnetLinkPattern, $torrentDetailHtml, $magnetMatches)) {
   					// echo "Magnet Link: " . $magnetMatches[1] . "\n";
   					$torrent = new Torrent();
   					$torrent->setTorrentName($torrentName);
   					$torrent->setMagnetLink($magnetMatches[1]);
   					$torrent->setOrigin(TorrentOrigin::SEARCH);
   						
   					if (!in_array($torrentName, $torrentNames, true)) {
   						$torrents[] = $torrent;
   						$torrentNames[] = $torrent->name;
   						$this->logger->debug("[EliteTorrent] Getting Torrent $torrentName <==> $torrentFileLink");
   					}
   				}
   			}
   		}
   	}
   
   	return $torrents;
   
   }
    
   
}