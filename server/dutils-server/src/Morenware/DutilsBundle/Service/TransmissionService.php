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
	
	const TRANSMISSION_HOST = "localhost";
	const TRANSMISSION_PORT = "9091";
	const TRANSMISSION_USERNAME = "transmission";
	const TRANSMISSION_PASSWORD = "ZVCvrasp";
	
	const BASE_TORRENTS_PATH = "/home/david/scripts/downloads";
	

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
		//TODO: use memcached here!
		
		if (!isset($this->sessionIdHeader)) {
			
			$host = self::TRANSMISSION_HOST;
			$port = self::TRANSMISSION_PORT;
			$username = self::TRANSMISSION_USERNAME;
			$password = self::TRANSMISSION_PASSWORD;
			
			$credentials = "$username:$password";
			$endpoint = "http://$host:$port/transmission/rpc";
			$this->logger->debug("The endpoint for invoking transmission for header is: \n $endpoint \n ");
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
			
			$matches = array();
			
			if (preg_match('/^(.*<code>)(.*)(<\/code>.*)$/', $result, $matches)) {
				// 0-> everything, 1 -> first (), 2 -> second ()
				$sessionIdHeader = $matches[2];
				$this->logger->debug("The session id header is ". $sessionIdHeader);
				$this->sessionIdHeader = $sessionIdHeader;
				
			}
			
			curl_close($curl);
		}
			    
	    return $this->sessionIdHeader;
		
	}
	
	//TODO: Add support for starting multiple downloads at the same time, like the upload feature in the WebInterface
	// of Transmission - Check RPC api or WebInterface code
	public function startDownloadInRemoteTransmission($torrent, $isFromFile = false) {
		
		// Ensure transmission has the right configuration (cache this to not call every time)
		$this->configureTransmission();
		
		$link = $torrent->getMagnetLink();
		$magnetLink = "$link";
	    $host = self::TRANSMISSION_HOST;
	    $port = self::TRANSMISSION_PORT;
	    $endpoint = "http://$host:$port/transmission/rpc";
	    $sessionIdHeader = $this->getSessionIdHeader();
	    $username = self::TRANSMISSION_USERNAME;
	    $password = self::TRANSMISSION_PASSWORD;
	    $credentials = "$username:$password";
	
	    $filenameParameter = $magnetLink;
	    
		if ($isFromFile) {
			$filenameParameter = $torrent->getFilePath();
		}    
		
	    $addTorrentJson = "{\"method\":\"torrent-add\",\"arguments\":{\"paused\":false,\"filename\":\"$filenameParameter\"} }";
	
	    $headers = array(
	            'Content-Type: application/json',
	            $sessionIdHeader,
	            "Authorization: Basic " . base64_encode($credentials)
	    );
	
	    //TODO: Use helper methods makeRequest, performRpcCall
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
	    		
	    		$result = curl_exec($curl);
	    		
		    	$this->logger->debug("Result of the call to Transmission is: " . $result);
		
		    	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		
		    	// Need to do this to be able to access the property with PHP -> operator
		    	$result = str_replace("torrent-added", "torrentadded", $result);
		    	
		    	$resultAsArray = json_decode($result);
		    	
		   
		    	//TODO: handle rest of errors?
		    	if ($status == '500') {
		    		$this->logger->warn("There was a failure -- retrying: " . $torrent->getTitle());
		    		$retryCount++;
		    		sleep(1);
		    		continue;
		    	}
		    	
		    	//TODO: better handling of lowercase,
		    	if (strpos($resultAsArray->result, "uccess") !== false) {
		        	$this->logger->debug("Successful call to Transmission -- torrent added: " . $torrent->getTitle());
		        	
		        	$torrentInfo = $resultAsArray->arguments->torrentadded;
		        	$nameAdded = str_replace('+', '.', $torrentInfo->name);
		        	$nameAdded = str_replace(' ', '.', $torrentInfo->name);
		        	$transmissionId = $torrentInfo->id;
		        	$hash = $torrentInfo->hashString;

		        	$torrent->setHash($hash);
		        	$torrent->setTransmissionId($transmissionId);
		        	$torrent->setTorrentName($nameAdded);
		        	
		        	// Relocate based on hash
		        	$this->relocateTorrent($nameAdded, $hash);
		        	
		    	} else if (strpos($resultAsArray->result, "duplicate") !== false) {	
		    		$this->logger->debug("Duplicated torrent: " . $torrent->getTitle() . " not adding "); 
		    		//TODO: it can be started / retrieved if needed using the id provided in the response
		    		$this->torrentService->delete($torrent);
		    	
		    	} else {
		    		$this->logger->warn("Error adding torrent -- retrying " .$torrent->getTitle());
		    		$retryCount++;
		    		continue;
		    	}
		
		    	$success = true;
		    	
		    	curl_close($curl);
		    	
	    	} catch (\Exception $e) {
	    		$this->logger->warn("Exception adding torrent -- retrying " .$torrent->getTitle()." exception: ".$e->getMessage());
	    		$retryCount++;
	    	}
		}
		
		if ($success) {
			$this->updateTorrentState($torrent,TorrentState::DOWNLOADING);
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
		
		$host = self::TRANSMISSION_HOST;
		$port = self::TRANSMISSION_PORT;
		$endpoint = "http://$host:$port/transmission/rpc";
		$sessionIdHeader = $this->getSessionIdHeader();
		$username = self::TRANSMISSION_USERNAME;
		$password = self::TRANSMISSION_PASSWORD;
		$credentials = "$username:$password";
		 	
		$headers = array(
				'Content-Type: application/json',
				$sessionIdHeader,
				"Authorization: Basic " . base64_encode($credentials)
		);
		
		$this->logger->debug("The endpoint to Transmission API is: ". $endpoint);
		
		list($result, $status) = $this->performRpcCall($endpoint, $headers, $jsonPayload);
		
		if ($status == 409) {
			list($result, $status) = $this->performRpcCall($endpoint, $headers, $jsonPayload);
		} 
		
		$resultAsClass = json_decode($result);
		
		return $resultAsClass;
	}
	
	/**
	 * Invoked from MonitorDownloadsCommand, so this is done in a separate php process
	 * 
	 * This can be invoked by, in general two API endpoints:
	 * 
	 * - One, to create a screen with progress bars showing status of torrents
	 * - Two, for another one to tidy up DB state of torrents and start further processing on them
	 * 
	 */
	public function checkTorrentsStatus() {
		
		// Percent done is a number between 0 and 1
		$requestPayload = array(
			"method" => "torrent-get",
			"arguments" => array("fields" => array("id", "name", "totalSize", "percentDone", "hashString")) 
		);
		
		$jsonRequest = json_encode($requestPayload);
		
		$result = $this->makeRequest($jsonRequest);
		
		$this->logger->debug("Result of torrents query is: ". json_encode($result->arguments->torrents));

		//TODO: This call should update Torrents in DB, maybe adding percent done, remaining time??
		$this->torrentService->updateDataForTorrents($result->arguments->torrents);
	}
	
	/**
	 * Each time Transmission finishes downloading something, executes a script which will end up calling this method.
	 * From here Filebot could be launched asynchronously to start the renaming process.
	 * 
	 * Other option is the polling every x time for completion of a torrent and then react -- less efficient.
	 * 
	 * The script in Transmission would act as callback doing a push notification (but general, we can't identify the torrents
	 * which were finished), maybe we can then pull information of all torrents and tidy up the DB <- sounds reasonable
	 * 
	 * The idea is:
	 * 
	 * - Send downloads to Transmission
	 * - Set up an script in Transmission to notify this App about finished downloads through a specific Endpoint in the API
	 * - That endpoint will then query the Transmission API for torrents status, recognize the ones that have been put into
	 *   DOWNLOADING, tidy up their state in DB and start renaming. Check finished ones -> percentDone or anything else?¿?
	 * - This saves a lot of unnecessary polling for potentially a lot of torrents
	 * 
	 */
	public function onDownloadCompleted() {
		//TODO:
	}
	
	
	public function relocateTorrent($torrentName, $torrentHash) {
		
		$newLocation = $this->getTorrentSubfolderPath($torrentName, $torrentHash);
		
		$this->logger->debug("Relocating torrent with $torrentName into subfolder $newLocation ");
		
		$requestPayload = array(
				"method" => "torrent-set-location",
				"arguments" => array("ids" => array($torrentHash), "location" => $newLocation, "move" => true)		
		);
		
		$jsonRequest = json_encode($requestPayload, JSON_UNESCAPED_SLASHES);
		
		$this->logger->debug("The payload to send to transmission API is $jsonRequest");
		
		$result = $this->makeRequest($jsonRequest);
		
		$this->logger->debug("Result of call is: ". json_encode($result));
		
		$this->logger->debug("Torrent RELOCATED");
		// Give appropriate permission to the path
		// chmod($newLocation, 0777);
	}
	
	/**
	 * Sets some global session properties in Transmission
	 * 
	 *  - Sets the download-dir to a known path (one with the right permission)
	 *  - Sets the "script-torrent-done-filename" and "script-torrent-done-enabled" values to a script which starts renaming command
	 * 
	 */
	//TODO: cache somewhere that this has been done properly to not keep doing it every time
	public function configureTransmission() {
	
		$this->logger->info("[TRANSMISSION-CONFIGURE-SESSION] Setting up transmission session settings");
		
		// This will prepare one script to execute the renaming in the scripts temporary area with execution permission for all
		$scriptToStartRenaming = $this->processManager->prepareScriptToExecuteSymfonyCommand(CommandType::RENAME_DOWNLOADS, true);
		
		$requestPayload = array(
				"method" => "session-set",
				"arguments" => array("download-dir" => self::BASE_TORRENTS_PATH, 
						             "script-torrent-done-enabled" => true,
									 "script-torrent-done-filename" => "$scriptToStartRenaming")
		);
	
		$jsonRequest = json_encode($requestPayload, JSON_UNESCAPED_SLASHES);
		
		$this->logger->debug("[TRANSMISSION-CONFIGURE-SESSION] The payload to send to transmission API is $jsonRequest");
		
		$result = $this->makeRequest($jsonRequest);
		
		$this->logger->debug("[TRANSMISSION-CONFIGURE-SESSION] The result to set Session settings in Transmission is: ". json_encode($result));
		
		$this->logger->debug("[TRANSMISSION-CONFIGURE-SESSION] Transmission Session properties are configured");
	}
	
	//TODO: cache this with memcached, session or DB
	public function getSessionInfo() {
		
		$this->logger->info("[TRANSMISSION-CONFIGURE] Getting transmission session properties");
		
		$requestPayload = array(
				"method" => "session-get",
				"arguments" => array("download-dir")
		);
		
		$jsonRequest = json_encode($requestPayload, JSON_UNESCAPED_SLASHES);
		
		$this->logger->debug("The payload to send to transmission API is $jsonRequest");
		
		$result = $this->makeRequest($jsonRequest);
		$this->logger->debug("Result of call is: ". json_encode($result));
		$resultAsAssociativeArray =  json_decode(json_encode($result, JSON_UNESCAPED_SLASHES), true, JSON_UNESCAPED_SLASHES);
		return $resultAsAssociativeArray;
	}
	
	
	public function getSessionProperty($sessionProperty) {
		
		$this->logger->info("[TRANSMISSION-CONFIGURE] Requesting value of property $sessionProperty");
		
		$sessionProperties = $this->getSessionInfo();
		$requestedPropertyPropertyValue = $sessionProperties["arguments"][$sessionProperty]; 
		
		$this->logger->info("[TRANSMISSION-CONFIGURE] The value for property $sessionProperty is $requestedPropertyPropertyValue");
		
		return $requestedPropertyPropertyValue;
	}
	
	public function getTorrentSubfolderPath($torrentName, $torrentHash) {
		$newPath = $this->getSessionProperty("download-dir") . "/" . $torrentName . "_" . $torrentHash;
		return $newPath;
	}

	
	
	
}