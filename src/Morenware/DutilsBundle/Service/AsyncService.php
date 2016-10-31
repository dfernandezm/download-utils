<?php
namespace Morenware\DutilsBundle\Service;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\DiExtraBundle\Annotation\Service;
use Morenware\DutilsBundle\Entity\Feed;

/** @Service("async.service") */
class AsyncService {
	
	/**
	 * @DI\Inject("logger")
	 */
	public $logger;

	// @DI\Inject("leezy.pheanstalk")
	/**
	 *
	 */
	public $broker;
	
	/**
	 * @DI\Inject("torrentfeed.service")
	 */
	public $torrentFeedService;
	
	const MAX_RETRY_COUNT = 10;
	
	const REQUESTS_QUEUE = "requests";
	
	const RESPONSES_QUEUE = "responses";
	
	/**
	 * Uses the given parameters to compose a message to produce in the queue
	 * 
	 * @param unknown $jobGuid
	 * @param unknown $data
	 * @return string
	 */
	public function prepareMessage($jobGuid, $type, $notifyUrl, $data) {
		$message = $jobGuid.'\n'.$type.'\n'.$notifyUrl.'\n';
		return $message;
	}
	
	/**
	 * Produces a message in a beanstalkd queue with retry.
	 * Registers a callback to handle the response
	 * 
	 * @param unknown $message
	 */
	public function sendMessage($message) {
		
		$success = false;
		$retryCount = 0;
		$exception = null;
		
		while(!$success && $retryCount < self::MAX_RETRY_COUNT) {
		
			try {
					
				$this->broker->useTube(self::REQUESTS_QUEUE)->put($message);
				$this->logger->debug("Message successfully put in ".self::REQUESTS_QUEUE." queue");
				$this->createWorkerIfNeeded();
				$success = true;
				
			} catch (Pheanstalk_Exception $e) {
				$this->logger->warn("Error occurred trying to put message in queue -- retrying".$e->getMessage()."\n");
				$retryCount++;
				$exception = $e;
			}
		}
		
		if ($retryCount >= 5) {
			$this->logger->error("Maximum number of retries exhausted -- giving up. Last exception was ".$exception->getMessage());
		}
	}
	
	public function pollResponsesQueue() {
		
		$this->logger->debug("Checking responses queue on demand...");
		
		$this->broker->watchOnly("responses");
	
		$this->logger->debug("Checking queue for responses");
		
		while($job = $this->broker->reserve(0)) {
			$this->logger->debug("Processing response \n".$job->getData());
			$this->processMessage($job->getData());
			$this->broker->delete($job);	
		}		
	}
	
	public function processMessage($message) {
		// Parse the message
		// Extract the job guid and update it to COMPLETED / FAILED
		// do further work depending on job type 
		$this->logger->debug("Executing actions \n");
	}
	
	
	
	
	
	
	
	
	
	
	
}