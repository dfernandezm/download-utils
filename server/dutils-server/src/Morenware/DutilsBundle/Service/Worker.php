<?php
namespace Morenware\DutilsBundle\Service;
class Worker {
	
	private $type;
	
	private $broker;
	
	private $logger;
	
	private $pid;
	
	const WORKER_ALIVE_TIME = 600;
	
	public function __construct($pid, $broker, $logger, $type) {
		$this->type = $type;
		$this->broker = $broker;
		$this->logger = $logger;
		$this->pid = $pid;
	}
	
	public function sendResponseMessage($message) {
		$this->broker->putInTube("responses", $message);
		$this->logger->debug("Worker: Response put in responses queue");
	}
	
	public function checkQueueAndExecute() {
	
		$this->broker->watchOnly("requests");
	
		$start = time();
		
		while (time() - $start < WORKER_ALIVE_TIME) {
	
			$this->logger->debug("Worker: Waiting for job...");
	
			while($job = $this->broker->reserve(0)) {
	
				$this->logger->debug("Worker:Processing job with id ".$job->getId()." and payload \n". $job->getData()."");
					
				try {
					$this->logger->debug("Worker: Processing work...");
					// isolate in separate transaction
					sleep(10);
					$this->delete($job);
					$this->logger->debug("Worker: Sending response back");
					$this->sendResponse($job->getId()."-SUCCESS");
					$this->delete($job);
				} catch (Exception $e) {
					$this->delete($job); "There was an error during the job -- retrying [TODO]";
					$this->broker->bury($job);
				}
			}
	
			sleep(5);
		}
		
		$this->logger->debug("Worker: Timed out");
		exit(0);
	}
	
	
}