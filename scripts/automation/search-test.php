<?php

class Torrent {

    public $name;
    public $magnetLink;
    public $torrentFile;
    public $torrentDate;

};

$eliteTorrent = false;
$useList = false; // Only EliteTorrent
$divxtotal = true;

// Elite Torrent
$searchString = $argv[1];

if ($eliteTorrent) {
    $pagination = isset($argv[2]) ? "/pag:" . $argv[2] : "";

    $baseUrl = "http://www.elitetorrent.net";
    $listMode = (($useList) ? "/modo:listado" : "");
    $mainUrl = $baseUrl . "/busqueda/" . $searchString . $listMode . $pagination;

    $getTorrentUrlPattern = '/href="(\/get-torrent[^\s"]+)/';
    $resultsUrlsPattern = '/href="(\/torrent[^\s"]+)/';
    $torrentMagnetLinkPattern = '/href="(magnet:[^\s"]+)/';
    $nameAndIdTorrentPattern = '/href="\/torrent\/([0-9]+)\/.*title="([^"]+)/';

} else if ($divxtotal) {

    $baseUrl = "http://www.divxtotal.com";
    $mainUrl = $baseUrl . "/buscar.php?busqueda=" . $searchString;
    $innerPageLinkPattern = '/href="(\/series\/[^\s"]+)/';
    $episodeNameAndTorrentFilePattern = '/href="(\/torrents_tor[^\s"]+).*>(.*)<\/a>/';
}

$resultsPageHtml = file_get_contents($mainUrl);

$torrents = array();

$torrentNames = array();

$torrentList = "";

if($useList) {

    if (preg_match_all($nameAndIdTorrentPattern, $resultsPageHtml, $matches)) {

        $idsList = $matches[1];
        $namesList = $matches[2];

        for ($i = 0; $i < count($idsList); $i++) {

            $torrentId = $idsList[$i];
            $torrentName = $namesList[$i];

            $torrent = new Torrent();
            $torrent->name = $torrentName;
            $torrent->torrentFile = $baseUrl . "/get-torrent/". $torrentId;

            echo "[EliteTorrent] Getting Torrent $torrent->name == $torrent->torrentFile \n";

        }
    }

} else {

    if ($divxtotal) {

        // Navigate to inner page for the tvshow

        if (preg_match($innerPageLinkPattern, $resultsPageHtml, $matches)) {

            $innerLinkForTvShow = $matches[1];

            echo "Inner link for TV Show is " . $baseUrl . $innerLinkForTvShow;

            $tvShowDetailHtml = file_get_contents($baseUrl . $innerLinkForTvShow);

            if (preg_match_all($episodeNameAndTorrentFilePattern, $tvShowDetailHtml, $matchesForEpisodes)) {

                $torrentFiles = $matchesForEpisodes[1];
                $episodeTitles = $matchesForEpisodes[2];

                for ($i = 0; $i < count($torrentFiles); $i++) {

                    $torrentFileLink = $torrentFiles[$i];
                    $episodeTitle = $episodeTitles[$i];

                    $torrent = new Torrent();
                    $torrent->name = $episodeTitle;
                    $torrent->torrentFile = $baseUrl . $torrentFileLink;

                    echo "[DivxTotal] Getting Torrent $torrent->name == $torrent->torrentFile \n";
                }
            }
        }

    } else {

        // In EliteTorrent for example, this navigates for each page (detail) and retrieves the links -- very slow
        if (preg_match_all($resultsUrlsPattern, $resultsPageHtml, $matches)) {

            $startTimeAll = time()*1000;

            foreach ($matches[1] as $partialTorrentUrl) {

                $startTimeEvery = time()*1000;

                $indexSlash = strrpos($partialTorrentUrl, "/");
                //echo "index is " . $indexSlash ." -- $partialTorrentUrl \n";
                // get Name of torrent
                $torrentName = substr($partialTorrentUrl, $indexSlash - strlen($partialTorrentUrl) + 1);
                // echo "Torrent name is $torrentName \n";
                $torrentDetailUrl = $baseUrl . $partialTorrentUrl;

                //$startTime = time()*1000;
                $torrentDetailHtml = file_get_contents($torrentDetailUrl);
                //echo "Gettig detail page took " . ((time()*1000)-$startTime) . "\n";
                // Get magnet links
                if(preg_match($torrentMagnetLinkPattern, $torrentDetailHtml, $magnetMatches)) {
                    // echo "Magnet Link: " . $magnetMatches[1] . "\n";
                    $torrent = new Torrent();
                    $torrent->name =  $torrentName;
                    $torrent->magnetLink = $magnetMatches[1];

                    if (!in_array($torrent->name, $torrentNames, true)) {
                        $torrents[] = $torrent;
                        $torrentNames[] = $torrent->name;
                        $torrentList = $torrentList . "$torrent->name \n";
                    }
                }

                echo "Gettig every torrent took " . ((time()*1000)-$startTimeEvery) . " ms \n";
            }

            echo "Getting all took " . ((time()*1000)-$startTimeAll) . " ms \n";
        }
    }
}

echo "List of Torrents \n " . $torrentList;

// Download torrent file first!!
//file_put_contents("/home/david/scripts/prison-torrent.torrent", file_get_contents("http://www.elitetorrent.net/get-torrent/10089"));


?>