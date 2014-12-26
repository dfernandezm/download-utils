<?php
namespace Morenware\DutilsBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;


/**
 *
 * @ORM\Entity
 * @ORM\Table(name="feed")
 *
 */
class Feed {
	
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=false)
	 */
	private $url;
	
	/**
	 * @ORM\Column(type="string", length=200, nullable=true)
	 */
	private $description;
	
	/**
	 * @ORM\Column(name="last_checked_date", type="datetime", nullable=true)
	 */
	private $lastCheckedDate;
	
	/**
	 * @ORM\Column(name="last_download_date", type="datetime", nullable=true)
	 */
	private $lastDownloadDate;
	
	/**
	 * @ORM\Column(name="active", type="boolean", nullable=true)
	 */
	private $active;
	
	
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
	public function getActive() {
		return $this->active;
	}
	public function setActive($active) {
		$this->active = $active;
		return $this;
	}
	
	
	
}