<?php
namespace Morenware\DutilsBundle\Entity;

class Feed {
	
	private $id;
	private $url;
	private $description;
	private $lastCheckedDate;
	private $lastDownloadDate;
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getUrl() {
		return $this->url;
	}
	public function setUrl($url) {
		$this->url = $url;
		return $this;
	}
	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}
	public function getLastCheckedDate() {
		return $this->lastCheckedDate;
	}
	public function setLastCheckedDate($lastCheckedDate) {
		$this->lastCheckedDate = $lastCheckedDate;
		return $this;
	}
	public function getLastDownloadDate() {
		return $this->lastDownloadDate;
	}
	public function setLastDownloadDate($lastDownloadDate) {
		$this->lastDownloadDate = $lastDownloadDate;
		return $this;
	}
	
	
}