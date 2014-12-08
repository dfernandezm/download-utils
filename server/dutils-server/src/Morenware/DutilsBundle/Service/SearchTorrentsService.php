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
	
	public function searchTorrentsInWebsites($searchQuery) {
		
		//$torrents = $this->searchEliteTorrent($searchQuery);
		
		// We need to paginate results here as the search retrieves the whole series in a single page...
		$torrents = $this->searchDivxTotal($searchQuery);
		
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
	
	
	public function searchDivxTotal($searchQuery) {
		
		$baseUrl = "http://www.divxtotal.com";
		$mainUrl = $baseUrl . "/buscar.php?busqueda=" . $searchQuery;
		$innerPageLinkPattern = '/href="(\/series\/[^\s"]+)/';
		$episodeNameAndTorrentFilePattern = '/href="(\/torrents_tor[^\s"]+).*>(.*)<\/a>/';
		

		$resultsPageHtml = file_get_contents($mainUrl);
		$this->logger->debug("000000000000000000 --- resultsPage \n". $searchQuery);
		$torrents = array();
		$torrentNames = array();
		
		$matches = array();
		
//		$arrayTokens = explode("+",$searchQuery);
		
		//TODO: investigate why aguila roja is here...
// 		$matchesAll = array();
// 		preg_match_all($innerPageLinkPattern, $resultsPageHtml, $matchesAll);
		
// 		for ($i = 0; $i < count($matchesAll); $i++) {
			
// 			foreach($matchesAll[$i] as $match) {
// 				$this->logger->debug("UUUUUUUUUUUUUUUUUUUUU Aguila roja:: ".$match);
// 			}
			
// 		}
		
		
		
		
		if (preg_match($innerPageLinkPattern, $resultsPageHtml, $matches)) {
		
			$innerLinkForTvShow = $matches[1];
		
			$this->logger->debug("Inner link for TV Show is $baseUrl$innerLinkForTvShow");
		
			$tvShowDetailHtml = file_get_contents($baseUrl . $innerLinkForTvShow);
		
			$matchesForEpisodes = array();
			
			if (preg_match_all($episodeNameAndTorrentFilePattern, $tvShowDetailHtml, $matchesForEpisodes)) {
		
				$torrentFiles = $matchesForEpisodes[1];
				$episodeTitles = $matchesForEpisodes[2];
		
				for ($i = 0; $i < count($torrentFiles); $i++) {
		
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
			}
		}
		
		return $torrents;
	}
}