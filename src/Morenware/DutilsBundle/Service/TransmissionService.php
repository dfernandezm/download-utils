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
use Morenware\DutilsBundle\Util\GuidGenerator;
use Symfony\Component\Validator\Constraints\Length;

/** @Service("transmission.service") */
class TransmissionService {

	private $logger;

	private $transmissionLogger;

	private $sessionIdHeader;

	const TRANSMISSION_RETRY_COUNT = 5;

	/** @DI\Inject("torrent.service") */
	public $torrentService;

	/** @DI\Inject("processmanager.service") */
	public $processManager;

	/** @DI\Inject("settings.service") */
	public $settingsService;

	private $transmissionConfigured = false;


   /**
	* @DI\InjectParams({
	*     "logger"  = @DI\Inject("logger"),
	*     "transmissionLogger" = @DI\Inject("monolog.logger.transmission")
	* })
	*/
	public function __construct($logger, $transmissionLogger) {

		$this->logger = $logger;
		$this->transmissionLogger = $transmissionLogger;
	}


	//TODO: Add support for starting multiple downloads at the same time, like the upload feature in the WebInterface
	// of Transmission - Check RPC api or WebInterface code
	//TODO: !!!!!This should execute in a transaction block -- make all methods not doing flush, commits!!!!
	public function startDownload($torrent, $isFromFile = false) {

		// Ensure transmission has the right configuration (cache this to not call every time)

		if (!$this->transmissionConfigured) {
			$this->configureTransmission();
			$this->transmissionConfigured = true;
		}

		$magnetLink = $torrent->getMagnetLink();

	    $filenameParameter = $magnetLink;

		if ($isFromFile) {
			$filenameParameter = $torrent->getTorrentFileLink();
		}

		if ($filenameParameter == null || strlen($filenameParameter) == 0) {
			$message = "Provided torrent magnet link or file is null or blank: $filenameParameter";
			$this->transmissionLogger->error($message);
			throw new \Exception($message, 400, null);
		}

	    //$addTorrentJson = "{\"method\":\"torrent-add\",\"arguments\":{\"paused\":false, \"filename\": \"$filenameParameter\" } }";

			// Add the torrent
			$requestPayload = array(
					"method" => "torrent-add",
					"arguments" => array("paused" => false, "filename" => $filenameParameter)
			);

			$jsonRequest = json_encode($requestPayload, JSON_UNESCAPED_SLASHES);
			$this->transmissionLogger->debug("[TRANSMISSION-TORRENT-ADD] The payload to send to transmission API is $jsonRequest");

	    try {

	    	$result = $this->executeTransmissionApiCall($jsonRequest);
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

	    		//TODO: Get also torrent seeds and size if not present
	    		$existingTorrent = $this->torrentService->findTorrentByHash($hash);

	    		if ($existingTorrent !== null) {

	    			$torrent = $existingTorrent;
	    			$this->logger->info("[STARTING-DOWNLOAD] Found torrent already in DB with the hash $hash -- " . $existingTorrent->getTorrentName());

	    		}

	    		$torrent->setHash($hash);
	    		$torrent->setTransmissionId($transmissionId);

	    		if ($torrent->getTorrentName() == null) {
	    			$torrent->setTorrentName($nameAdded);
	    		}

	    		if ($torrent->getTitle() === "Unknown" || $torrent->getTitle() == null) {
	    			$torrent->setTitle($nameAdded);
	    		}

					$torrent->setTitle($this->torrentService->clearSpecialChars($torrent->getTitle()));
					$torrent->setTorrentName($this->torrentService->clearSpecialChars($torrent->getTorrentName()));

	    		// Relocate based on hash
	    		$newLocation = $this->relocateTorrent($torrent->getTorrentName(), $hash);
	    		$torrent->setFilePath($newLocation);

	    		$this->createOrUpdateTorrentData($torrent, TorrentState::DOWNLOADING);

	    	}

	    } catch (\Exception $e) {
	    	$this->logger->error("[START-DOWNLOAD] Could not start downloading torrent, marking torrent as FAILED_DOWNLOAD -- " .$torrent->getTitle() . " - " . $e->getMessage());
	    	$this->createOrUpdateTorrentData($torrent,TorrentState::FAILED_DOWNLOAD_ATTEMPT);
	    }

	    return $torrent;
	}

	public function createOrUpdateTorrentData($torrent, $torrentState) {
		$torrent->setState($torrentState);
		//TODO: Warning! this flushes and clears, change to isolated if it is executing in a transaction block
		$this->torrentService->update($torrent);
	}

	/**
	 * Poll Transmission for status of current torrents. The database is updated with
	 * current status of torrents.
	 *
	 */
	public function checkTorrentsStatus() {

		// Percent done is a number between 0 and 1
		$requestPayload = array(
				"method" => "torrent-get",
				"arguments" => array("fields" => array("id", "name", "totalSize", "percentDone", "hashString", "torrentFile", "magnetLink", "rateDownload"))
		);

		$jsonRequest = json_encode($requestPayload);

		$result = $this->executeTransmissionApiCall($jsonRequest);

		$this->transmissionLogger->debug("[TRANSMISSION-API-CALL] Result of torrents query is: ". json_encode($result->arguments->torrents));

		$updatedTorrents = $this->torrentService->updateDataForTorrents($result->arguments->torrents);

		return $updatedTorrents;
	}


	public function executeTransmissionApiCall($jsonPayload) {

		$transmissionSettings = $this->settingsService->getDefaultTransmissionSettings();

		$host = $transmissionSettings->getIpOrHost();
		$port = $transmissionSettings->getPort();
		$endpoint = "http://$host:$port/transmission/rpc";
		$username = $transmissionSettings->getUsername();
		$password = $transmissionSettings->getPassword();
		$credentials = "$username:$password";

		// Execute call with retry

		$success = false;
		$retryCount = 0;
		$exception = null;
		$lastResult = null;

		while (!$success && $retryCount < self::TRANSMISSION_RETRY_COUNT) {

			try {

				$sessionIdHeader = $this->getSessionIdHeader($transmissionSettings);
				$headers = array(
						'Content-Type: application/json',
						$sessionIdHeader,
						"Authorization: Basic " . base64_encode($credentials)
				);

				$this->transmissionLogger->debug("[TRANSMISSION-API-CALL] Calling transmission API endpoint with ID Header $sessionIdHeader ". $endpoint);
				$result = $this->performRpcCall($endpoint, $headers, $jsonPayload);
				$resultAsClass = json_decode($result);

				$success = true;
				$this->transmissionLogger->debug("[TRANSMISSION-API-CALL] Successful call");

			} catch (\Exception $e) {

				if ($e->getCode() == 409) {
					$this->transmissionLogger->warn("[TRANSMISSION-API-CALL] Detected conflict, force renewing of Session ID: ". $e->getMessage());
					$this->forceTransmissionSessionIdRenewal();
				} else {
					$this->transmissionLogger->warn("[TRANSMISSION-API-CALL] Exception calling transmission API exception -- retrying: " . $e->getMessage());
					$retryCount++;
					$exception = $e;
				}

				sleep(1);
			}
		}

		if (!$success) {

			$message = "Error trying to call Transmission API after 5 tries -- giving up: ";

			if ($exception != null ) {
				// to main logger as well
				$this->logger->error($message . $exception->getMessage());
				$this->transmissionLogger->error($message . $exception->getMessage());
				throw $exception;
			} else {
				$this->logger->error($message . $lastResult);
				$this->transmissionLogger->error($message . $lastResult);
				throw new \Exception($message . $lastResult, 500, null);
			}
		}

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

		$result = curl_exec($curl);
		$this->transmissionLogger->debug("[TRANSMISSION-API-CALL] Result of the call to Transmission is: " . $result);
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		$containsSuccess = strpos($result, "uccess");
		$statusCode = intval($status);

		if ($statusCode !== 200 || $containsSuccess === false) {

			if (strpos($result, "duplicate") !== false) {
				$this->transmissionLogger->debug("[TRANSMISSION-API-CALL] Trying to add duplicate torrent, skipping");
			} else {
				$message = "[TRANSMISSION-API-CALL] Error calling API, status $status" . $result;
    			$this->transmissionLogger->warn($message);
    			curl_close($curl);
    			throw new \Exception($message, $statusCode, null);
			}
    	}

		curl_close($curl);

		return $result;
	}

	private function forceTransmissionSessionIdRenewal() {
		unset($this->sessionIdHeader);
	}

	public function getSessionIdHeader($transmissionSettings, $forceRenewal = false) {
		//TODO: use memcached here!
		if (!isset($this->sessionIdHeader) || $forceRenewal) {

			$host = $transmissionSettings->getIpOrHost();
			$port = $transmissionSettings->getPort();
			$username = $transmissionSettings->getUsername();
			$password = $transmissionSettings->getPassword();
			$credentials = "$username:$password";
			$endpoint = "http://$host:$port/transmission/rpc";

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

			$this->transmissionLogger->debug("[TRANSMISSION-SESSIONID] The result of invoking transmission for header is: \n $result \n ");

			$sessionIdHeader = null;
			$matches = array();

			if (preg_match('/^(.*<code>)(.*)(<\/code>.*)$/', $result, $matches)) {
				// 0-> everything, 1 -> first (), 2 -> second ()
				$sessionIdHeader = $matches[2];
				$this->transmissionLogger->debug("[TRANSMISSION-SESSIONID] The session id header is ". $sessionIdHeader);
				$this->sessionIdHeader = $sessionIdHeader;
			}

			curl_close($curl);
		}

		return $this->sessionIdHeader;

	}


	public function relocateTorrent($torrentName, $torrentHash) {
		$this->logger->debug("Executing torrent relocation for $torrentName");
		$newLocation = $this->getTorrentSubfolderPath($torrentName, $torrentHash);

		$this->logger->debug("Relocating torrent with $torrentName into subfolder $newLocation ");
		$this->transmissionLogger->debug("[TRANSMISSION-RELOCATE] Relocating torrent with $torrentName into subfolder $newLocation ");

		$requestPayload = array(
				"method" => "torrent-set-location",
				"arguments" => array("ids" => array($torrentHash), "location" => $newLocation, "move" => true)
		);

		$jsonRequest = json_encode($requestPayload, JSON_UNESCAPED_SLASHES);
		$this->transmissionLogger->debug("[TRANSMISSION-RELOCATE] The payload to send to transmission API is $jsonRequest");

		$result = $this->executeTransmissionApiCall($jsonRequest);
		$this->transmissionLogger->debug("[TRANSMISSION-RELOCATE] Result of call is: ". json_encode($result));

		$this->logger->debug("Torrent $torrentName successfully RELOCATED in $newLocation");
		$this->transmissionLogger->debug("[TRANSMISSION-RELOCATE] Torrent $torrentName successfully RELOCATED in $newLocation");


		// Start the torrent again, as it could have been paused
		$requestPayload = array(
				"method" => "torrent-start-now",
				"arguments" => array("ids" => array($torrentHash))
		);

		$jsonRequest = json_encode($requestPayload, JSON_UNESCAPED_SLASHES);
		$this->transmissionLogger->debug("[TRANSMISSION-START-NOW] The payload to send to transmission API is $jsonRequest");

		$result = $this->executeTransmissionApiCall($jsonRequest);

		return $newLocation;
	}

	/**
	 *
	 * Delete torrent and data in Transmission. Update DB to DELETED state
	 * This will allow to re-add the torrent and download it again.
	 *
	 * @param unknown $torrent
	 */
	public function deleteTorrent($torrentHash) {

		$requestPayload = array(
				"method" => "torrent-remove",
				"arguments" => array("ids" => array($torrentHash),
						             "delete-local-data" => true)
		);

		$jsonRequest = json_encode($requestPayload, JSON_UNESCAPED_SLASHES);

		$this->transmissionLogger->debug("[TRANSMISSION-DELETE-TORRENT] The payload to send to transmission API is $jsonRequest");

		$result = $this->executeTransmissionApiCall($jsonRequest);

		$this->transmissionLogger->debug("[TRANSMISSION-DELETE-TORRENT] The result after deletion is: ". json_encode($result));

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

		$this->transmissionLogger->info("[TRANSMISSION-CONFIGURE-SESSION] Setting up transmission session settings");

		// This will prepare one script to execute a push notification from transmission when a download finishes
		$notificationScript = $this->processManager->prepareScriptToExecuteNotifyCall();

		$baseDownloadsPath = $this->settingsService->getDefaultTransmissionSettings()->getBaseDownloadsDir();
		//TODO: remove hardcoded /mediacenter -- use baseLibraryPath
		$requestPayload = array(
				"method" => "session-set",
				"arguments" => array("download-dir" => $baseDownloadsPath,
						             "script-torrent-done-enabled" => true,
									 "script-torrent-done-filename" => "/mediacenter/notify.sh",
									 "start-added-torrents" => true)
		);

		$jsonRequest = json_encode($requestPayload, JSON_UNESCAPED_SLASHES);

		$this->transmissionLogger->debug("[TRANSMISSION-CONFIGURE-SESSION] The payload to send to transmission API is $jsonRequest");

		$result = $this->executeTransmissionApiCall($jsonRequest);

		$this->transmissionLogger->debug("[TRANSMISSION-CONFIGURE-SESSION] The result to set Session settings in Transmission is: ". json_encode($result));
		$this->transmissionLogger->debug("[TRANSMISSION-CONFIGURE-SESSION] Transmission Session properties are configured");
	}

	private function getSessionInfo() {

		$this->transmissionLogger->info("[TRANSMISSION-CONFIGURE] Getting transmission session properties");

		$requestPayload = array(
				"method" => "session-get",
				"arguments" => array("download-dir")
		);

		$jsonRequest = json_encode($requestPayload, JSON_UNESCAPED_SLASHES);

		$this->transmissionLogger->debug("The payload to send to transmission API is $jsonRequest");

		$result = $this->executeTransmissionApiCall($jsonRequest);
		$this->transmissionLogger->debug("Result of call is: ". json_encode($result));
		$resultAsAssociativeArray =  json_decode(json_encode($result, JSON_UNESCAPED_SLASHES), true, JSON_UNESCAPED_SLASHES);
		return $resultAsAssociativeArray;
	}

	private function getTorrentSubfolderPath($torrentName, $torrentHash) {
		$newPath = $this->settingsService->getDefaultTransmissionSettings()->getBaseDownloadsDir() . "/" . $torrentName . "_" . $torrentHash;
		return $newPath;
	}

	private function getSessionProperty($sessionProperty) {
		$this->transmissionLogger->info("[TRANSMISSION-CONFIGURE] Requesting value of property $sessionProperty");
		$sessionProperties = $this->getSessionInfo();
		$requestedPropertyPropertyValue = $sessionProperties["arguments"][$sessionProperty];
		$this->transmissionLogger->info("[TRANSMISSION-CONFIGURE] The value for property $sessionProperty is $requestedPropertyPropertyValue");
		return $requestedPropertyPropertyValue;
	}


}
