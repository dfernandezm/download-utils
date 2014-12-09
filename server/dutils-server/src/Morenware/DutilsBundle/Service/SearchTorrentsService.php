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

/** @Service("search.service") */
class SearchTorrentsService {

	private $logger;

   /**
	* @DI\InjectParams({
	*     "logger"  = @DI\Inject("logger")
	* })
	*
	*/
	public function __construct($logger) {

		$this->logger = $logger;
	}
	
	public function searchTorrentsInWebsites($searchQuery, $limit = 25, $offset = 0) {
		
		//$torrents = $this->searchEliteTorrent($searchQuery);
		
		// We need to paginate results here as the search retrieves the whole series in a single page...
		$torrents = $this->searchDivxTotal($searchQuery, $limit, $offset);
		
		return $torrents;
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
	
	
	public function searchDivxTotal($searchQuery, $limit = 25, $offset = 0) {
		
		$baseUrl = "http://www.divxtotal.com";
		
		$searchQuery = urlencode($searchQuery);
		
		$mainUrl = $baseUrl . "/buscar.php?busqueda=" . $searchQuery;
		$innerPageLinkPattern = '/href="(\/series\/[^\s"]+)/';
		$episodeNameAndTorrentFilePattern = '/href="(\/torrents_tor[^\s"]+).*>(.*)<\/a>/';
		$moreThanOnePagePattern = '/href="(buscar\.php\?busqueda=[^"]+)&pagina=([0-9])"/';
		
		// use this to extract movies
		$moviesInnerPageLinkPattern = '/href="(peliculas\/torrent\/[0-9]+\/.*\/)/'; 
		
		// Number of results
		$numberOfResultsPattern = '/<h3>(.*)torrents[\s]+encontrados.*<\/h3>/';
		
		
		$resultsPageHtml = file_get_contents($mainUrl);
	
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
		
			$tvShowDetailHtml = file_get_contents($baseUrl . $innerLinkForTvShow);
		
			$matchesForEpisodes = array();
			
			if (preg_match_all($episodeNameAndTorrentFilePattern, $tvShowDetailHtml, $matchesForEpisodes)) {
		
				$torrentFiles = $matchesForEpisodes[1];
				$episodeTitles = $matchesForEpisodes[2];
		
				$total = count($torrentFiles);
				
				$this->logger->debug("Total is $total - offset $offset - limit $limit");
				$limit = $limit >= $total ? $total : $limit;
				
				for ($i = $offset; $i < ($offset+$limit); $i++) {
		
					$torrentFileLink = $torrentFiles[$i];
					$episodeTitle = $episodeTitles[$i];
		
					if (!in_array($episodeTitle, $torrentNames, true)) {
						$torrent = new Torrent();
						$torrent->setTorrentName($episodeTitle);
						$torrentFileLink = $baseUrl . $torrentFileLink;
						$torrent->setTorrentFileLink($torrentFileLink);
							
						$torrents[] = $torrent;
						$torrentNames[] = $episodeTitle;	
					}
					
					$this->logger->debug("[DivxTotal] Getting Torrent $episodeTitle <==> $torrentFileLink \n");
				}
				
				$currentOffset = $i;
			}
		}
		
		return array($torrents, $currentOffset, $total);
	}
	
	public function hasMoreThanOnePageDivxTotal($resultsHtml, $moreThanOnePagePattern) {
		
		$matches = array();
		
		if (preg_match_all($moreThanOnePagePattern, $resultsHtml, $matches)) {
			return array(true, max($matches[2]));
		} else {
			return array(false, 0);
		}
	}
}