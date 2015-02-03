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
	
	/** @DI\Inject("settings.service") */
	public $settingsService;
	
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
	
	//TODO: Add support for starting multiple downloads at the same time, like the upload feature in the WebInterface
	// of Transmission - Check RPC api or WebInterface code
	public function startDownload($torrent, $isFromFile = false) {
		
		// Ensure transmission has the right configuration (cache this to not call every time)
		$this->configureTransmission();
		$link = $torrent->getMagnetLink();
		$magnetLink = "$link";
	  
	    $filenameParameter = $magnetLink;
	    
		if ($isFromFile) {
			$filenameParameter = $torrent->getFilePath();
		}    
		
	    $addTorrentJson = "{\"method\":\"torrent-add\",\"arguments\":{\"paused\":false,\"filename\":\"$filenameParameter\"} }";
	
	    try {
	    	
	    	$result = $this->executeTransmissionApiCall($addTorrentJson);
	    	// Need to do this to be able to access the property with PHP -> operator
	    	$result = str_replace("torrent-added", "torrentadded", json_encode($result));
	    	$resultAsArray = json_decode($result);
	    	
	    	if (strpos($resultAsArray->result, "duplicate") !== false) {
	    		
	    		$this->logger->debug("[START-DOWNLOAD] Duplicated torrent: " . $torrent->getTitle() . ", skipping it");
	    		//TODO: it can be started / retrieved if needed using the id provided in the response
	    		$this->torrentService->delete($torrent);
	    		
	    	} else {
	    		
	    		$this->logger->debug("[START-DOWNLOAD] Successful call to Transmission -- torrent added: " . $torrent->getTitle());
	    		 
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
	    		
	    		$this->updateTorrentState($torrent,TorrentState::DOWNLOADING);
	    		$this->processManager->startDownloadsMonitoring();
	    	}
	    	
	    } catch (\Exception $e) {
	    	$this->logger->error("[START-DOWNLOAD] Could not start downloading torrent, marking torrent as FAILED_DOWNLOAD -- " .$torrent->getTitle() . " - " . $e->getMessage());
	    	$this->updateTorrentState($torrent,TorrentState::FAILED_DOWNLOAD_ATTEMPT);
	    }
	}
	
	public function updateTorrentState($torrent, $torrentState) {
		$torrent->setState($torrentState);
		$this->torrentService->merge($torrent);
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
		$result = $this->executeTransmissionApiCall($jsonRequest);
	
		$this->logger->debug("Result of torrents query is: ". json_encode($result->arguments->torrents));
		$this->torrentService->updateDataForTorrents($result->arguments->torrents);
	}
	
	
	public function executeTransmissionApiCall($jsonPayload) {
		
		$transmissionSettings = $this->settingsService->getDefaultTransmissionSettings();
		
		$host = $transmissionSettings->getIpOrHost();
		$port = $transmissionSettings->getPort();
		$endpoint = "http://$host:$port/transmission/rpc";
		$username = $transmissionSettings->getUsername();
		$password = $transmissionSettings->getPassword();
		$sessionIdHeader = $this->getSessionIdHeader($transmissionSettings);
		$credentials = "$username:$password";
		 	
		$headers = array(
				'Content-Type: application/json',
				$sessionIdHeader,
				"Authorization: Basic " . base64_encode($credentials)
		);
		
		$this->logger->debug("[TRANSMISSION-API-CALL] Calling transmission API endpoint: ". $endpoint);
		
		$result = $this->performRpcCall($endpoint, $headers, $jsonPayload); 
		
		$resultAsClass = json_decode($result);	
		return $resultAsClass;
	}
	
	
	public function performRpcCall($endpoint, $headers, $jsonPayload) {
	
		$curl = curl_init();
	
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $endpoint,
			CURLOPT_POST => 1,
			CURLOPT_HTTPHEADER => $headers,
			CURLOPT_POSTFIELDS => $jsonPayload
		));
	
		$success = false;
		$retryCount = 0;
		$exception = null;
			
		while (!$success && $retryCount < self::TRANSMISSION_RETRY_COUNT) {
				
			try {
	
				$result = curl_exec($curl);
				$this->logger->debug("[TRANSMISSION-API-CALL] Result of the call to Transmission is: " . $result);
				$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
				
				$containsSuccess = strpos($result, "uccess");
				$statusCode = intval($status);
				
				
				if ($statusCode !== 200 || $containsSuccess === false) {
					
					if (strpos($result, "duplicate") !== false) {
						$this->logger->debug("[TRANSMISSION-API-CALL] Trying to add duplicate torrent, skipping");
					} else {
		    			$this->logger->warn("[TRANSMISSION-API-CALL] Error calling API, status $status -- retrying: " . $result);
		    			$retryCount++;
		    			sleep(1);
		    			continue;
					}
		    	}
				
				$success = true;
				$this->logger->debug("[TRANSMISSION-API-CALL] Successful call");
	
			} catch (\Exception $e) {
				$this->logger->warn("[TRANSMISSION-API-CALL] Exception calling transmission API exception -- retrying: " . $e->getMessage());
				$retryCount++;
				$exception = $e;
				sleep(1);
			}
		}
	
		curl_close($curl);
		
		if ($success) {
			// if ($status == 409) {
				// if conflict, retry with header
				//$result = $this->performRpcCall($endpoint, $headers, $jsonPayload);
			//}
		} else {
			$this->logger->error("Error trying to call Transmission API after 5 tries -- giving up ". $exception->getMessage());
			throw $exception;
		}
			
		return $result;
	}
	
	public function getSessionIdHeader($transmissionSettings) {
		//TODO: use memcached here!
		if (!isset($this->sessionIdHeader)) {
				
			$host = $transmissionSettings->getIpOrHost();
			$port = $transmissionSettings->getPort();
			$username = $transmissionSettings->getUsername();
			$password = $transmissionSettings->getPassword();		
			$credentials = "$username:$password";
			$endpoint = "http://$host:$port/transmission/rpc";
			
			$this->logger->debug("The endpoint for invoking transmission for header is: \n $endpoint \n ");
			
			$headers = array(
					'Content-Type: application/json',
					"Authorization: Basic " . base64_encode($credentials)
			);

			//TODO: factorize in a method -- prepareApiCall...
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => $endpoint,
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
	
	
	public function relocateTorrent($torrentName, $torrentHash) {
		
		$newLocation = $this->getTorrentSubfolderPath($torrentName, $torrentHash);
		
		$this->logger->debug("Relocating torrent with $torrentName into subfolder $newLocation ");
		
		$requestPayload = array(
				"method" => "torrent-set-location",
				"arguments" => array("ids" => array($torrentHash), "location" => $newLocation, "move" => true)		
		);
		
		$jsonRequest = json_encode($requestPayload, JSON_UNESCAPED_SLASHES);
		$this->logger->debug("The payload to send to transmission API is $jsonRequest");
		
		$result = $this->executeTransmissionApiCall($jsonRequest);
		$this->logger->debug("Result of call is: ". json_encode($result));
		$this->logger->debug("Torrent successfully RELOCATED in $newLocation");
	}
	
	/**
	 * Sets some global session properties in Transmission
	 * 
	 *  - Sets the download-dir to a known path (one with the right permission)
	 *  - Sets the "script-torrent-done-filename" and "script-torrent-done-enabled" values to a script which starts renaming command
	 * 
	 */
	//TODO: cache somewhere that this has been done properly to not keep doing it every time
	private function configureTransmission() {
	
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
		
		$result = $this->executeTransmissionApiCall($jsonRequest);
		
		$this->logger->debug("[TRANSMISSION-CONFIGURE-SESSION] The result to set Session settings in Transmission is: ". json_encode($result));
		$this->logger->debug("[TRANSMISSION-CONFIGURE-SESSION] Transmission Session properties are configured");
	}

	private function getSessionInfo() {
		
		$this->logger->info("[TRANSMISSION-CONFIGURE] Getting transmission session properties");
		
		$requestPayload = array(
				"method" => "session-get",
				"arguments" => array("download-dir")
		);
		
		$jsonRequest = json_encode($requestPayload, JSON_UNESCAPED_SLASHES);
		
		$this->logger->debug("The payload to send to transmission API is $jsonRequest");
		
		$result = $this->executeTransmissionApiCall($jsonRequest);
		$this->logger->debug("Result of call is: ". json_encode($result));
		$resultAsAssociativeArray =  json_decode(json_encode($result, JSON_UNESCAPED_SLASHES), true, JSON_UNESCAPED_SLASHES);
		return $resultAsAssociativeArray;
	}
	
	private function getTorrentSubfolderPath($torrentName, $torrentHash) {
		$newPath = $this->settingsService->getDefaultTransmissionSettings()->getBaseDownloadsDir() . "/" . $torrentName . "_" . $torrentHash;
		return $newPath;
	}
	
	private function getSessionProperty($sessionProperty) {
		$this->logger->info("[TRANSMISSION-CONFIGURE] Requesting value of property $sessionProperty");
		$sessionProperties = $this->getSessionInfo();
		$requestedPropertyPropertyValue = $sessionProperties["arguments"][$sessionProperty];
		$this->logger->info("[TRANSMISSION-CONFIGURE] The value for property $sessionProperty is $requestedPropertyPropertyValue");
		return $requestedPropertyPropertyValue;
	}

	
	
	
}