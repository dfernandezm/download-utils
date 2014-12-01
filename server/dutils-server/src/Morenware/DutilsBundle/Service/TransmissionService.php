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

/** @Service("transmission.service") */
class TransmissionService {

	private $logger;
	
	private $sessionIdHeader;
	
	const TRANSMISSION_RETRY_COUNT = 5;
	
	/** @DI\Inject("torrent.service") */
	public $torrentService;
	
	/** @DI\Inject("processmanager.service") */
	public $processManager;
	

   /**
	* @DI\InjectParams({
	*     "logger"  = @DI\Inject("logger")
	* })
	*
	*/
	public function __construct($logger) {

		$this->logger = $logger;
	}
	
	public function getSessionIdHeader() {

		if (!isset($this->sessionIdHeader)) {
			$host = "raspbmc";
			$port = "9091";
			$username = "transmission";
			$password = "ZVCvrasp";
			
			$credentials = "$username:$password";
			$endpoint = "http://$host:$port/transmission/rpc";
			
			$headers = array(
					'Content-Type: application/json',
					"Authorization: Basic " . base64_encode($credentials)
			);
			
			$curl = curl_init();
			curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => "$endpoint",
			CURLOPT_HTTPHEADER => $headers
			));
			
			$result = curl_exec($curl);
			$this->logger->debug("The result of invoking transmission for header is: \n $result \n ");
			$sessionIdHeader = null;
			
			if (preg_match('/^(.*<code>)(.*)(<\/code>.*)$/', $result, $matches)) {
				$sessionIdHeader = $matches[2];
				$this->logger->debug("The session id header is ". $sessionIdHeader);
				$this->sessionIdHeader = $sessionIdHeader;
			}
			
			curl_close($curl);
		}
			    
	    return $this->sessionIdHeader;
		
	}
	
	public function startDownloadInRemoteTransmission($torrent) {
		
		//$link = "magnet:?xt=urn:btih:02a5ad1a8af7a8b7bff49c8fae39d84a0a25c96a&dn=Predestination+(2014)+1080p&tr=http://exodus.desync.com:6969/announce&tr=udp://tracker.openbittorrent.com:80/announce&tr=udp://tracker.1337x.org:80/announce&tr=udp://exodus.desync.com:6969/announce&tr=udp://tracker.yify-torrents.com/announce";
	    $link = $torrent->getMagnetLink();
		$magnetLink = "$link";
	    $host = "raspbmc";
	    $port = "9091";
	    $endpoint = "http://$host:$port/transmission/rpc";
	    $sessionIdHeader = $this->getSessionIdHeader();
	    $username = "transmission";
	    $password = "ZVCvrasp";
	    $credentials = "$username:$password";
	    
	    //$addTorrent = array( "method" => "torrent-add", "arguments" => array ("paused" => false, "filename" => "$magnetLink"));
	    //json_encode
	
	    $addTorrentJson = "{\"method\":\"torrent-add\",\"arguments\":{\"paused\":false,\"filename\":\"$magnetLink\"} }";
	
	    $headers = array(
	            'Content-Type: application/json',
	            $sessionIdHeader,
	            "Authorization: Basic " . base64_encode($credentials)
	    );
	
	    $curl = curl_init();
	
	    curl_setopt_array($curl, array(
	        CURLOPT_RETURNTRANSFER => 1,
	        CURLOPT_URL => "$endpoint",
	        CURLOPT_POST => 1,
	        CURLOPT_HTTPHEADER => $headers,
	        CURLOPT_POSTFIELDS => $addTorrentJson
	    ));
	
	    
	    $success = false;
	    $retryCount = 0;
	    
	    while (!$success && $retryCount < self::TRANSMISSION_RETRY_COUNT) {
	    	
	    	try {
	    		// http://showrss.info/feeds/930.rss
	    		$result = curl_exec($curl);
	    		
		    	$this->logger->debug("Result of the call to Transmission is: " . $result);
		
		    	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		
		    	$resultAsArray = json_decode($result);
		   
		    	//TODO: handle rest of errors?
		    	if ($status == '500') {
		    		$this->logger->warn("There was a failure -- retrying: " . $torrent->getTitle());
		    		$retryCount++;
		    		sleep(1);
		    		continue;
		    	}
		    	
		    	//TODO: better handling of lowercase
		    	if (strpos($resultAsArray->result, "Success") !== false || strpos($resultAsArray->result, "success") !== false) {
		        	$this->logger->debug("Successful call to Transmission -- torrent added: " . $torrent->getTitle());
		        	
		        	$torrentInfo = $resultAsArray->arguments->torrent-added;
		        	$nameAdded = $torrentInfo->name;
		        	$transmissionId = $torrentInfo->id;
		        	$hash = $torrentInfo->hashString;

		        	$torrent->setHash($hash);
		        	$torrent->setTransmissionId($transmissionId);
		        	$torrent->setTorrentName($nameAdded);
		        	
		    	} else if (strpos($resultAsArray->result, "duplicate") !== false) {	
		    		$this->logger->debug("Duplicated torrent: " . $torrent->getTitle() . " not adding ");
		    		$this->torrentService->delete($torrent);
		    		continue;
		    	} else {
		    		$this->logger->warn("Error adding torrent -- retrying " .$torrent->getTitle());
		    		$retryCount++;
		    		continue;
		    	}
		
		    	curl_close($curl);
		    	
		    	$success = true;
		    	
	    	} catch (\Exception $e) {
	    		$this->logger->warn("Exception adding torrent -- retrying " .$torrent->getTitle());
	    		$retryCount++;
	    	}
		}
		
		if ($success) {
			$this->updateTorrentState($torrent,TorrentState::DOWNLOADING);
			// start monitoring if not already -- wrap up torrent state when finished and rename etc.
			$this->processManager->startDownloadsMonitoring();
		} else {
			$this->updateTorrentState($torrent,TorrentState::FAILED_DOWNLOAD_ATTEMPT);
			$this->logger->error("Could not download torrent after 5 tries -- giving up -- " .$torrent->getTitle());
		}
		
	    // Throttling -- wait 1 second between sucesive calls
	    sleep(1);
	}
	
	public function updateTorrentState($torrent, $torrentState) {
		$torrent->setState($torrentState);
		$this->torrentService->merge($torrent);
	}
	
	
	public function performRpcCall($endpoint, $headers, $jsonPayload) {
		
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => "$endpoint",
		CURLOPT_POST => 1,
		CURLOPT_HTTPHEADER => $headers,
		CURLOPT_POSTFIELDS => $jsonPayload
		));
		
		$result = curl_exec($curl);
			
		$this->logger->debug("Result of the call to Transmission is: " . $result);
		
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		
		curl_close($curl);
		
	 	return array($result, $status);
	}
	
	public function makeRequest($jsonPayload) {
		
		$host = "raspbmc";
		$port = "9091";
		$endpoint = "http://$host:$port/transmission/rpc";
		$sessionIdHeader = $this->getSessionIdHeader();
		$username = "transmission";
		$password = "ZVCvrasp";
		$credentials = "$username:$password";
		 	
		$headers = array(
				'Content-Type: application/json',
				$sessionIdHeader,
				"Authorization: Basic " . base64_encode($credentials)
		);
		
		list($result, $status) = $this->performRpcCall($endpoint, $headers, $jsonPayload);
		
		if ($status == 409) {
			list($result, $status) = $this->performRpcCall($endpoint, $headers, $jsonPayload);
		} 
		
		$resultAsArray = json_decode($result);
		
		return $resultAsArray;
	}
	
	/**
	 * Invoked from MonitorDownloadsCommand, so this is done in the background??
	 * 
	 */
	public function checkTorrentsStatus() {
		
		$requestPayload = array(
			"method" => "torrent-get",
			"arguments" => array("fields" => array("id", "name", "totalSize", "percentDone")) 
		);
		
		$jsonRequest = json_encode($requestPayload);
		
		$result = $this->makeRequest($jsonRequest);
		
		$this->logger->debug("Result of torrents query is: ". json_encode($result->arguments->torrents));

		//TODO: update database with results to start renaming afterwards !!
		$this->torrentService->updateDataForTorrents($result->arguments->torrents);
	}
}