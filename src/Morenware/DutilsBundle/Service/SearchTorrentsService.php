<?php
namespace  Morenware\DutilsBundle\Service;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;
use Morenware\DutilsBundle\Entity\SearchWebsite;
use Morenware\DutilsBundle\Entity\SearchWebsiteType;
use Morenware\DutilsBundle\Entity\Torrent;
use Morenware\DutilsBundle\Entity\TorrentDateType;
use Symfony\Component\DomCrawler\Crawler;


/** @Service("search.service") */
class SearchTorrentsService {

	private $logger;

	/** @DI\Inject("transmission.service") */
	public $transmissionService;

	/** @DI\Inject("torrent.service") */
    public $torrentService;

    /** @DI\Inject("searchwebsite.service")
     *
     */
    public $searchWebsiteService;

	/**
	 * @DI\Inject("%torrents_temp_path%")
	 */
	public $torrentsTempPath;

	/**
	 * @DI\Inject("%search_cache_dir%")
	 */
	public $searchCacheDir;

	private $searchWebsites;

	const MAIN_SECTION = "MAIN";
	const DETAIL_SECTION = "DETAIL";
	const DIVX_TOTAL_ID = "DT";
	const KICKASS_TORRENTS_ID = "KT";
	const PIRATE_BAY_ID = "TPB";

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

	private function initializeWebsites() {
		$websites = array();

        // The Pirate Bay
        $pirateBay = $this->searchWebsiteService->findBySiteId(self::PIRATE_BAY_ID);

        if ($pirateBay == null) {
            $this->logger->info("[SEARCH-WEBSITES] Inserting default website The Pirate Bay");

            $pirateBay = new SearchWebsite();
            $pirateBay->setName("The Pirate Bay");
            $pirateBay->setMainUrl("https://pirateproxy.sx");
            $pirateBay->setSiteId(self::PIRATE_BAY_ID);
            $pirateBay->setStructureType(SearchWebsiteType::LIST_TYPE);
            $pirateBay->setTorrentDateType(TorrentDateType::DATE);

            // 0/3/0 means order by uploaded date in The Pirate bay
            $pirateBay->setSearchUrl("{baseUrl}/search/{searchQuery}/0/3/0");
            $pirateBay->setTorrentMainResultsFilterString("#main-content #searchResult tr");
            $pirateBay->setTorrentTitlesFilterString("td > div.detName > a");
            $pirateBay->setTorrentMagnetLinksFilterString("td > a"); // The first link
            $pirateBay->setTorrentFilesFilterString(null);
            $pirateBay->setTorrentAttributesFilterString("td > .detDesc");
            $pirateBay->setMainLanguage("en");

            $this->searchWebsiteService->create($pirateBay);

        }

        // Kickass Torrents
        $kickassTorrents = $this->searchWebsiteService->findBySiteId(self::KICKASS_TORRENTS_ID);

		if ($kickassTorrents == null) {

            $this->logger->info("[SEARCH-WEBSITES] Inserting default website Kickass Torrents");

            $kickassTorrents = new SearchWebsite();
            $kickassTorrents->setName("Kickass torrents");
            $kickassTorrents->setMainUrl("http://kickass-torrents.nl");
            $kickassTorrents->setSiteId(self::KICKASS_TORRENTS_ID);
            $kickassTorrents->setStructureType(SearchWebsiteType::LIST_TYPE);
            $kickassTorrents->setTorrentDateType(TorrentDateType::AGE);

            // Ordered by more recent ones
            $kickassTorrents->setSearchUrl("{baseUrl}/usearch/{searchQuery}/?field=time_add&sorder=desc");
            $kickassTorrents->setTorrentMainResultsFilterString("div table.data tr");
            $kickassTorrents->setTorrentTitlesFilterString("td div.torrentname div.markeredBlock a.cellMainLink");
            $kickassTorrents->setTorrentMagnetLinksFilterString('td div.iaconbox a[title*="magnet"]');
            $kickassTorrents->setTorrentFilesFilterString(null);
            $kickassTorrents->setTorrentAttributesFilterString("td.center");
            $kickassTorrents->setMainLanguage("en");

            $this->searchWebsiteService->create($kickassTorrents);
        }

        // DivxTotal
        $divxTotal = $this->searchWebsiteService->findBySiteId(self::DIVX_TOTAL_ID);

		if ($divxTotal == null) {

            $this->logger->info("[SEARCH-WEBSITES] Inserting default website Divx Total");

            $divxTotal = new SearchWebsite();
            $divxTotal->setName("DivX Total");
            $divxTotal->setMainUrl("http://www.divxtotal.com");
            $divxTotal->setSiteId(self::DIVX_TOTAL_ID);
            $divxTotal->setStructureType(SearchWebsiteType::MAIN_DETAIL);
            $divxTotal->setTorrentDateType(TorrentDateType::DATE);

            // Ordered by more recent ones
            $divxTotal->setSearchUrl("{baseUrl}/buscar.php?busqueda={searchQuery}&orden=1");

            $divxTotal->setTorrentMainResultsFilterString("table.fichserietabla tr");
            $divxTotal->setTorrentTitlesFilterString("td.capitulonombre a");
            $divxTotal->setTorrentMagnetLinksFilterString(null);
            $divxTotal->setTorrentFilesFilterString("td.capitulonombre a");

            // Only date in this page
            $divxTotal->setTorrentAttributesFilterString("td.capitulofecha");
            $divxTotal->setMainLanguage("es");

            $this->searchWebsiteService->create($divxTotal);
        }

		$websites["TPB"] = $pirateBay;
		$websites["KT"] = $kickassTorrents;
		$websites["DT"] = $divxTotal;
		$this->searchWebsites = $websites;
	}

	public function searchTorrentsInWebsites($searchQuery, $websitesToSearch, $limit = 25, $offset = 0) {

        // Initialize the websites in case they aren't yet
        $this->initializeWebsites();

		// We need to paginate results here as the search could retrieves the whole series in a single page
		$torrents = array();
		$currentOffset = $offset;
		$total = 0;

		$isDivxTotal = false;

		foreach ($websitesToSearch as $websiteId) {
			$this->logger->debug("[SEARCH] Searching torrents in website with id $websiteId");

			if ($websiteId === self::KICKASS_TORRENTS_ID) {
				list($torrentsFound, $currentOffsetFound, $totalFound) = $this->searchKickassTorrents($searchQuery);
				$this->logger->debug("Found " . count($torrentsFound) . " torrents in Katproxy");
			}

			if ($websiteId === self::DIVX_TOTAL_ID) {
				$isDivxTotal = true;
				list($torrentsFound, $currentOffsetFound, $totalFound) = $this->searchDivxTotal($searchQuery);
				$this->logger->debug("Found " . count($torrentsFound) . " torrents in DivXTotal");
			}

			if ($websiteId === self::PIRATE_BAY_ID) {
				list($torrentsFound, $currentOffsetFound, $totalFound) = $this->searchThePirateBay($searchQuery);
				$this->logger->debug("Found " . count($torrentsFound) . " torrents in The Pirate Bay");
			}

			$torrents = array_merge($torrents, $torrentsFound);
			$currentOffset = $currentOffset + $currentOffsetFound;
			$this->logger->debug("Current offset is $currentOffset");
			$total = $total + $totalFound;
		}


		$torrents = $this->sortByDate($torrents);

		if (!$isDivxTotal) {
			$torrents = $this->sortBySeeds($torrents);
		}

		return array($torrents, $currentOffset, $total);
	}

	public function searchDivxTotal($searchQuery, $limit = 25, $offset = 0) {

		$divxTotalSite = $this->searchWebsites["DT"];

		$baseUrl = $divxTotalSite->getMainUrl();
		$searchQuery = urlencode($searchQuery);

		// Sort by date
		$partialSearchUrl = str_replace("{baseUrl}", $baseUrl, $divxTotalSite->getSearchUrl());
		$searchUrl = str_replace("{searchQuery}", $searchQuery, $partialSearchUrl);

		$this->logger->info("[SEARCH-DIVXTOTAL] Searching using main url $searchUrl");

		$torrents = array();
		$total = 0;

		// It is main-detail site, search main first

		try {

			$resultsPageHtml = $this->getInitialSearchResultsFromSite(self::DIVX_TOTAL_ID, self::MAIN_SECTION, $searchUrl, $searchQuery);

		} catch (\Exception $e) {
			$this->logger->error("Error accessing site " . $divxTotalSite->getName() . " -- " . $e->getMessage());
			return array($torrents, $total, $total);
		}

		$innerPageLinkPattern = '/href="(\/series\/[^\s"]+)/';
		//$moreThanOnePagePattern = '/href="(buscar\.php\?busqueda=[^"]+)&pagina=([0-9])"/';

		$currentOffset = $offset;
		$matches = array();

		if (preg_match($innerPageLinkPattern, $resultsPageHtml, $matches)) {

			$innerLinkForTvShow = $matches[1];
			$completeInnerLink = $baseUrl . $innerLinkForTvShow;

			$this->logger->debug("Inner link for search is $completeInnerLink");

			try {
				$detailHtml = $this->getInitialSearchResultsFromSite(self::DIVX_TOTAL_ID, self::DETAIL_SECTION, $completeInnerLink, $searchQuery);
			} catch (\Exception $e) {
				$this->logger->error("Error accessing site -- detail page " . $divxTotalSite->getName() . " -- " . $e->getMessage());
				return array($torrents, $total, $total);
			}

			$crawler = new Crawler($detailHtml);

			$mainResultsFilterString = $divxTotalSite->getTorrentMainResultsFilterString();
			$crawlerRows = $crawler->filter($mainResultsFilterString);

			$total = iterator_count($crawlerRows) - 1; // not accurate, headers every season

			$limit = $limit >= $total ? $total-$offset : $limit;

			$j = 0;

			if ($total > 1) {

				$this->logger->debug("[SEARCH-DIVXTOTAL] Found $total rows to filter as results");

				$headers = 0;

				foreach ($crawlerRows as $i => $content) {

					if ($j > $limit) {
						break;
					}

					$subCrawler = new Crawler($content);

					$nodeText = $subCrawler->text();

					if (strpos($nodeText, "Fecha") !== false) {
						$headers++;
					    continue;
					}

 					$torrentAttributesFilterString = $divxTotalSite->getTorrentAttributesFilterString();
 					$episodeDate = $subCrawler->filter($torrentAttributesFilterString)->extract("_text");

 					$torrentTitlesFilterString = $divxTotalSite->getTorrentTitlesFilterString();
 					$titles = $subCrawler->filter($torrentTitlesFilterString)->extract("_text");

 					$torrentFileLinksFilterString = $divxTotalSite->getTorrentFilesFilterString();
 					$torrentFileLinks = $subCrawler->filter($torrentFileLinksFilterString)->extract("href");

					$count = count($titles);

					if ($count > 0) {

						$k = 0;

						$torrentName = $titles[$k];
						$torrentFileLink = $baseUrl.$torrentFileLinks[$k];
						$date = new \DateTime(trim($episodeDate[$k]));
						$date = new \DateTime($date->format('Y-m-d H:i:s'));
						$seeds = null;
						$size = null;
						$this->logger->debug("[SEARCH-DIVXTotal] Torrent found: $torrentName, $torrentFileLink");
						$this->logger->debug("[Search-DixTotal]  Date is =====> ". $date->format('Y-m-d H:i:s'));

						$torrent = $this->createTorrentSearchResult($torrentName, $torrentName, null, $torrentFileLink, $date, $size, $seeds);
						$torrents[] = $torrent;
					}

					$j++;
				}
			}
		   $currentOffset = $j == 0 ? $j : $j - 1;
		}



		$this->logger->info("[DIVX-TOTAL] Found " . count($torrents) . " torrents.");

		return array($torrents, $currentOffset, $total);
	}


   public function searchKickassTorrents($searchQuery, $limit = 25, $offset = 0) {

     $kickassSite = $this->searchWebsites["KT"];

     $baseUrl = $kickassSite->getMainUrl();
     $searchQuery = urlencode($searchQuery);

     $partialSearchUrl = str_replace("{baseUrl}", $baseUrl, $kickassSite->getSearchUrl());
     $searchUrl = str_replace("{searchQuery}", $searchQuery, $partialSearchUrl);

     $this->logger->info("Connecting to site for searching $searchUrl");

     $torrents = array();
     $total = 0;

     try {

     	$resultsPageHtml = $this->getInitialSearchResultsFromSite(self::KICKASS_TORRENTS_ID, self::MAIN_SECTION, $searchUrl, $searchQuery);

     } catch (\Exception $e) {
     	$this->logger->error("Error accessing site " . $kickassSite->getName() . " -- " . $e->getMessage());
     	return array($torrents, $total, $total);
     }

     $crawler = new Crawler($resultsPageHtml);

     $mainResultsFilterString = $kickassSite->getTorrentMainResultsFilterString();
     $crawlerRows = $crawler->filter($mainResultsFilterString);

     $total = iterator_count($crawlerRows) - 1; // minus header row

     $torrents = array();

     if ($total > 0) {

     	$this->logger->debug("[SEARCH-KICKASS] Found $total rows to filter as results");

     	foreach ($crawlerRows as $i => $content) {

     		$subCrawler = new Crawler($content);

     		$torrentTitlesFilterString = $kickassSite->getTorrentTitlesFilterString();
     		$titles = $subCrawler->filter($torrentTitlesFilterString)->extract("_text");

     		$magnetLinksFilterString = $kickassSite->getTorrentMagnetLinksFilterString();
     		$magnetLinks = $subCrawler->filter($magnetLinksFilterString)->extract("href");

     		// size, files, age, seed, leech
     		$torrentAttributesFilterString = $kickassSite->getTorrentAttributesFilterString();
     		$torrentAttributes = $subCrawler->filter($torrentAttributesFilterString)->extract("_text");

     		$count = count($titles);

     		if ($count > 0) {
     		 	$k = 0;
     			$torrentName = $titles[$k];
                $magnetLink = $magnetLinks[$k];
     			$age = $torrentAttributes[2];
     			$date = $this->convertAgeToDate($age);
     			$seedsStr = $torrentAttributes[3];
     			$seeds = intval($seedsStr);
     			$sizeStr = $torrentAttributes[0];
     			$size = $this->parseSizeToNumber($sizeStr);

     			$this->logger->debug("[SEARCH-KICKASS] Torrent found: $torrentName -- $magnetLink -- Age ". $date->format('Y-m-d H:i:s') . " -- Seed $seeds");

     			$torrent = $this->createTorrentSearchResult($torrentName, $torrentName, $magnetLink, null, $date, $size, $seeds);
     			$torrents[] = $torrent;
     		}
     	}
     }

     $currentOffset = $total;
     return array($torrents, $currentOffset, $total);

     //TODO: use the feed link to generate Feed object and then generate torrents!!
     // Example: http://katproxy.com/usearch/better%20call%20saul/?rss=1
   }

   public function searchThePirateBay($searchQuery, $limit = 25, $offset = 0) {

   	$pirateBaySite = $this->searchWebsites["TPB"];

   	$mainUrl = $pirateBaySite->getMainUrl();
   	$searchQuery = urlencode($searchQuery);

   	// 0/3/0 means order by uploaded date in The Pirate bay
   	$partialSearchUrl = str_replace("{baseUrl}",$mainUrl, $pirateBaySite->getSearchUrl());
   	$searchUrl = str_replace("{searchQuery}", $searchQuery, $partialSearchUrl);

   	$this->logger->info("[SEARCH-TPB] Searching using $searchUrl");

   	$torrents = array();
   	$currentOffset = 0;
   	$total = 0;

   	try {

   		$resultsPageHtml = $this->getInitialSearchResultsFromSite(self::PIRATE_BAY_ID, self::MAIN_SECTION, $searchUrl, $searchQuery);

   	} catch (\Exception $e) {
   		$this->logger->error("Error accessing site " . $e->getMessage());
   		return array($torrents, $total, $total);
   	}

   	$crawlerRows = $this->getInitialFilterFromResultsPage($resultsPageHtml, $pirateBaySite->getTorrentMainResultsFilterString());
   	$total = iterator_count($crawlerRows) - 1; // minus header row

   	$torrents = array();
   	$torrentTitlesFilterExpression = $pirateBaySite->getTorrentTitlesFilterString();
   	$magnetLinksOrTorrentFilesFilterExpression = $pirateBaySite->getTorrentMagnetLinksFilterString();

   	// Only date and size
   	$torrentAttributesFilterExpression = $pirateBaySite->getTorrentAttributesFilterString();

   	// In TPB, the seeders and leechers are in the regular table at the rightmost spaces
   	$seedersAndLeechersFilterExpression = 'td';

   	if ($total > 1) {

   		$this->logger->debug("[SEARCH-PIRATEBAY] Found $total rows to filter as results");

   		foreach ($crawlerRows as $i => $content) {

   			$subCrawler = new Crawler($content);

   			if ($subCrawler->filter("th")->count() > 0 ) {
   				continue;
   			}

   			$titles = $subCrawler->filter($torrentTitlesFilterExpression)->extract("_text");
   			$magnetLinks = $subCrawler->filter($magnetLinksOrTorrentFilesFilterExpression)->eq(0)->extract("href");

   			// size, date
   			$torrentAttributes = $this->getTorrentAttributesResultFromTPB($subCrawler, $torrentAttributesFilterExpression);
   			$seedsText = $subCrawler->filter($seedersAndLeechersFilterExpression)->eq(2)->text();

   			$count = count($titles);

   			for ($k = 0; $k < $count; $k++) {

   				$torrentName = $titles[$k];
   				$magnetLink = $magnetLinks[$k];
   				$size = $torrentAttributes["size"];
   				$date = $torrentAttributes["date"];

   				$seeds = intval($seedsText);

   				$this->logger->debug("[SEARCH-TPB] Torrent found: title $torrentName,
   						size $size, seeds $seeds, date " . $date->format('Y-m-d'));

   				$torrent = $this->createTorrentSearchResult($torrentName, $torrentName, $magnetLink, null, $date, $size, $seeds);

   				$torrents[] = $torrent;
   			}
   		}
   	}

   	$currentOffset = $total;

   	return array($torrents, $currentOffset, $total);

   }

   private function createTorrentSearchResult($torrentName, $torrentTitle, $magnetLink, $fileLink, $date, $size, $seeds) {

	   	$torrent = new Torrent();
	   	$torrent->setTorrentName($torrentName);
	   	$torrent->setTitle($torrentName);
	   	$torrent->setMagnetLink($magnetLink);
	   	$torrent->setTorrentFileLink($fileLink);
	   	$torrent->setDate($date);

	   	// Store size in MB
	   	$torrent->setSize($size);
	   	$torrent->setSeeds($seeds);

	   	$torrent->setState("NEW");

	   	$hash = null;

	    $existingTorrent = null;

	   	if ($magnetLink !== null) {

	   		$hashPattern = '/urn:btih:(.*)&dn=/';
	   		$matches = array();

	   		if (preg_match($hashPattern, $magnetLink, $matches)) {
	   			$hash = $matches[1];
	   			$existingTorrent = $this->torrentService->findTorrentByHash($hash);
	   		}

	   	} else {
	   		$existingTorrent = $this->torrentService->findTorrentByMagnetOrFile($fileLink);
	   	}

	   	if ($existingTorrent !== null) {
	   		$this->logger->warn("[SEARCH-TORRENTS-MATCH] Matched torrent $torrentName " . $existingTorrent->getHash());
	   		return $existingTorrent;
	   	}

	   	return $torrent;
   }

   private function getInitialSearchResultsFromSite($siteId, $siteSection, $searchUrl, $urlEncodedSearchQuery) {
	   	$resultsPageHtml = $this->getFromCache($siteId, $siteSection, $urlEncodedSearchQuery);

	   	if ($resultsPageHtml == null) {
	   		$this->logger->debug("Cache miss, connecting to website and caching");


            $ctx = stream_context_create(array('http'=>
                array(
                    'timeout' => 15,  // 15 seconds of timeout
                )
            ));

	   		$resultsPageHtml = @file_get_contents($searchUrl, false, $ctx);

	   		if ($resultsPageHtml === FALSE) {
	   			$this->logger->error("Cannot connect to site $siteId");
	   			throw new \Exception("Cannot connect to site $siteId");
	   		}

	   		$this->writeCacheFile($siteId, $siteSection, $urlEncodedSearchQuery, $resultsPageHtml);
	   	} else {
	   		$this->logger->debug("Cache hit, getting cached content");
	   	}

	   	return $resultsPageHtml;
   }

   private function getInitialFilterFromResultsPage($resultsPageHtml, $filterString) {
   	$crawler = new Crawler($resultsPageHtml);
   	$crawlerRows = $crawler->filter($filterString);

   	return $crawlerRows;
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

   public function getTorrentAttributesResultFromTPB($subCrawler, $torrentAttributesFilterExpression) {
   	  $torrentAttributesRawText = $subCrawler->filter($torrentAttributesFilterExpression)->extract("_text");

   	  $this->logger->debug("[SEARCH-PIRATEBAY] Torrent Attributes: " . print_r($torrentAttributesRawText,true));

   	  $torrentAttributes = array();

   	  if (count($torrentAttributesRawText) == 0) {
   	  	$this->logger->warn("[SEARCH-PIRATEBAY] Empty attributes string detected, possible header column");
   	  	$torrentAttributes["date"] = new \DateTime();
   	  	$torrentAttributes["size"] = 0;
   	  	return $torrentAttributes;
   	  }

   	  $torrentAttributesTextStr = $torrentAttributesRawText[0];

   	  //Uploaded 03-26 03:57, Size 345.63 MiB, ULed by
   	  //Uploaded 08-25 2005, Size 8.14 GiB, ULed by
   	  $dateAndSizePattern = '/ploaded\s+(.*),\s*[S|s]ize\s+(.*),/';

   	  $matches = array();

   	  if (preg_match($dateAndSizePattern, $torrentAttributesTextStr, $matches)) {

   	  	 $rawDate = $matches[1];
   	  	 $rawSize = $matches[2];

   	  	 $torrentAttributes["size"] = $this->parseSizeToNumber($rawSize);
   	  	 $torrentAttributes["date"] = $this->parseDateFromRawTPB($rawDate);

   	  } else {
   	  	$this->logger->warn("[SEARCH-PIRATEBAY] Could not extract date and size from raw string - $torrentAttributesTextStr");
   	  	$torrentAttributes["date"] = new \DateTime();
   	  	$torrentAttributes["size"] = 0;

   	  }

   	  return $torrentAttributes;

   }

   private function getQualityFromTorrentFileName($torrentFileLink) {
   	//TODO:
   }

   public function torrentAlreadyExists($torrentFileNameOrMagnetLink) {
   	$hash = base64_encode($torrentFileNameOrMagnetLink);
   	return $hash;
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

   private function parseSizeToNumber($size) {
   	$this->logger->debug("[SEARCH] About to parse size from $size");
   	$normalizedSizeStr = str_replace(" ", "", strtolower($size));

    if (strpos($normalizedSizeStr, "mb") !== false || strpos($normalizedSizeStr, "mib") !== false) {
   		return intval(round(floatval(str_replace("mb","",str_replace("mib","",$normalizedSizeStr)))));
   	} else if (strpos($normalizedSizeStr, "gb") !== false || strpos($normalizedSizeStr, "gib") !== false) {
   		return intval(floatval(str_replace("gb", "", str_replace("gib","",$normalizedSizeStr)))*1024);
   	} else {
   		$this->logger->warn("[SEARCH] Invalid size for torrent detected parsing $size string, falling back to 0");
   		return 0;
   	}
   }

   private function parseDateFromRawTPB($rawDate) {
   	$date = new \DateTime();
   	$datePattern = "/(.*)\s+(.*)/";
   	$matches = array();
   	if (preg_match($datePattern,$rawDate,$matches)) {

   		$dayAndMonth = $matches[1];
   	    $yearOrTime = $matches[2];

   	    $dayAndMonthArr = explode("-", $dayAndMonth);
   	    $month = $dayAndMonthArr[0];
   	    $day = $dayAndMonth[1];

   	    if (!strpos($yearOrTime,":")) { // If does not contain the colon (:), it will be a year
   	    	$year = trim($yearOrTime);
   	    } else {
   	    	$year = $date->format('Y'); // get current year
   	    }

   	    // set date
   	    $date->setDate(intval($year), intval($month), intval($day));

   	} else {
   		$this->logger->warn("[SEARCH-PIRATEBAY] Cannot discover proper date value from raw $rawDate");
   	}

   	return $date;

   }

   private function sortBySeeds($torrents) {

   	 $seedSort = function ($torrentA, $torrentB) {

   	 	if ($torrentA->getSeeds() === $torrentB->getSeeds()) {
   	 		return 0;
   	 	}

   	 	return ($torrentA->getSeeds() < $torrentB->getSeeds()) ? 1 : -1;
   	 };

   	 if (usort($torrents, $seedSort)) {
   	 	$this->logger->debug("[SEARCH] Torrents successfully sorted by seed count");
   	 } else {
   	 	$this->logger->error("[SEARCH] ERROR sorting torrents");
   	 }

   	 return $torrents;

   }

   private function sortByDate($torrents) {
   	$dateSort = function ($torrentA, $torrentB) {

   		if ($torrentB->getDate() == null) {
   			return -1;
   		}

   		if ($torrentA->getDate() == null) {
   			return 1;
   		}

   		$timeA = $torrentA->getDate()->getTimestamp();
   		$timeB = $torrentB->getDate()->getTimestamp();

   		if ($timeA === $timeB) {
   			return 0;
   		}

   		return ($timeA < $timeB) ? 1 : -1;
   	};

   	if (usort($torrents, $dateSort)) {
   		$this->logger->debug("[SEARCH] Torrents successfully sort by DATE");
   	} else {
   		$this->logger->error("[SEARCH] ERROR sorting torrents");
   	}

   	return $torrents;
   }

}
