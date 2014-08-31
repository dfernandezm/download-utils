<?php
namespace Morenware\DutilsBundle\Entity;

class DownloadJob {
	
	private $creationTime;
	private $startingTime;
	private $finishedTime;
	private $downloadState;

	
	public function get() {
		$download = new DownloadJobState();
	}

}
