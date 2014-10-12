<?php
namespace Morenware\DutilsBundle\Service;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\DiExtraBundle\Annotation\Service;

/** @Service("async.service") */
class AsyncService {
	
	/**
	 * @DI\Inject("logger")
	 */
	public $logger;
	
	/**
	 * @DI\Inject("leezy.pheanstalk")
	 */
	public $broker;
	
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
	public function prepareMessage($jobGuid, $workerType, $data) {
		
		$message = $jobGuid.'\n'.$workerType.'\n'.$data;
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
		
		while(!$success && $retryCount < MAX_RETRY_COUNT) {
		
			try {
					
				$jobId = $this->broker->useTube(REQUESTS_QUEUE)->put($message);
				$this->logger->debug("Job successfully put in ".REQUESTS_QUEUE." queue -- id is $jobId");
				$this->registerMessageHandler(RESPONSES_QUEUE);
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
	
	
	public function registerMessageHandler($tubeName) {
		
		$pid = pcntl_fork();
		
		if ($pid) {
			// parent
			$this->logger->debug("Successfully spawned child with pid $pid to check $tubeName queue");
			$this->modifyNumberOfChildren(true);
			return;
			
		} else {
			
			// Child goes into daemon mode
			$childPid = posix_getpid();
	
			fclose(STDIN);  // Close all of the standard
			fclose(STDOUT); // file descriptors as we
			fclose(STDERR); // are running as a daemon.
			
			$this->logger->debug("Daemon [$childPid]: Checking responses queue");
	
			$start = time();
			$timeout = 5*60; // 5 minutes
	
			$this->broker->watchOnly("responses");
	
			while(time() - $start < $timeout) {
				$this->logger->debug("Daemon [$childPid]: Checking responses... \n");
				$response = $this->readResponse($childPid);
					
				if ($response !== false) {
					$this->logger->debug("Daemon [$childPid]: successfully processed responses -- exiting");
					exit(0);
				}
				
				sleep(1);
				$runningTime = time() - $start;
				$this->logger("Daemon [$childPid]: Was $runningTime seconds running");
			}
	
			$this->logger("Daemon [$childPid]: Timed out. Exiting");
			exit(0);
		}
	}
	
	public function readResponse($childPid) {
	
		$this->logger->debug("Daemon [$childPid]: Checking queue for responses");
		$jobs = 0;
		
		while($job = $this->broker->reserve(0)) {
			$this->logger->debug("Daemon [$childPid]: Processing response back: \n".$job->getData());
			// Execute something isolated in a separate db transaction
			sleep(3);
			$this->broker->delete($job);
			$jobs++;
		}
		
		return $jobs != 0;
	}
	
	/**
	 * Creates a background worker to handle a request. 
	 * 
	 * The worker runs for a time and switches off itself.
	 * 
	 * @param unknown $type
	 */
	public function createWorkerIfNeeded() {
		
		$pid = pcntl_fork();
		
		if ($pid) {
			// parent
			$this->logger->debug("Successfully spawned worker with pid $pid to handle requests queue");
			return;
				
		} else {
			
			// Child goes into daemon mode
			$workerPid = posix_getpid();
			
			fclose(STDIN);  // Close all of the standard
			fclose(STDOUT); // file descriptors as we
			fclose(STDERR); // are running as a daemon.
			
			$worker = new Worker($workerPid, $this->broker, $this->logger, WorkerType::TRANSMISSION);
			$worker->checkQueueAndExecute();
		}
	}
	
	public function geNumberOfWorkers() {
		// Use shared memory to store number of workers
	}
	
	public function increaseNumberOfWorkers() {
		// Use shared memory segments
	}
	
	public function decreaseNumberOfWorkers() {
		// Use shared memory segments
	}
	
}