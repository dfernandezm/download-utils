<?php

function searchEliteTorrent($searchQuery, $page = null) {
	 
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