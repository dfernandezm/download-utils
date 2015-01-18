<?php
namespace Morenware\DutilsBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;


/**
 * 
 * @ORM\Entity
 * @ORM\Table(name="torrent")
 * 
 */
class Torrent {
	
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $guid;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $title;
	
	/**
	 * @ORM\Column(type="string", length=200, nullable=true)
	 */
	protected $torrentName;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $hash;
	
	/**
	 * @ORM\Column(name="magnet_link", type="string", length=300, nullable=true)
	 */
	protected $magnetLink;
	
	/** 
	 * @ORM\Column(type="datetime", nullable=true) 
	 * 
	 */
	protected $date;
	
	/**
	 * @ORM\Column(type="string", length=300, nullable=true)
	 */
	protected $asset;
	
	/**
	 * @ORM\Column(type="string", length=300, nullable=true)
	 */
	protected $state;
	
	/**
	 * @ORM\Column(name="content_type", type="string", length=300, nullable=true)
	 */
	protected $contentType;
	
	/**
	 * @ORM\Column(name="file_path", type="string", length=300, nullable=true)
	 */
	protected $filePath;
	
	/**
	 * @ORM\Column(name="transmission_id", type="integer", nullable=true)
	 */
	protected $transmissionId;
	
	/**
	 * @ORM\Column(name="origin", type="string", nullable=true)
	 */
	protected $origin;

	/**
	 * @ORM\Column(name="torrent_file_link", type="string", nullable=true)
	 */
	protected $torrentFileLink;
	
	/**
	 * @ORM\Column(name="percent_done", type="float", nullable=true)
	 */
	protected $percentDone;
	
	
		
	
	public function getTitle() {
		return $this->title;
	}
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}
	public function getHash() {
		return $this->hash;
	}
	public function setHash($hash) {
		$this->hash = $hash;
		return $this;
	}
	public function getMagnetLink() {
		return $this->magnetLink;
	}
	public function setMagnetLink($magnetLink) {
		$this->magnetLink = $magnetLink;
		return $this;
	}
	public function getDate() {
		return $this->date;
	}
	public function setDate($date) {
		$this->date = $date;
		return $this;
	}
	public function getAsset() {
		return $this->asset;
	}
	public function setAsset($asset) {
		$this->asset = $asset;
		return $this;
	}
	public function getState() {
		return $this->state;
	}
	public function setState($state) {
		$this->state = $state;
		return $this;
	}
	public function getContentType() {
		return $this->contentType;
	}
	public function setContentType($contentType) {
		$this->contentType = $contentType;
		return $this;
	}
	public function getFilePath() {
		return $this->filePath;
	}
	public function setFilePath($filePath) {
		$this->filePath = $filePath;
		return $this;
	}
	public function getOrigin() {
		return $this->origin;
	}
	public function setOrigin($origin) {
		$this->origin = $origin;
		return $this;
	}
	public function getGuid() {
		return $this->guid;
	}
	public function setGuid($guid) {
		$this->guid = $guid;
		return $this;
	}
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getTransmissionId() {
		return $this->transmissionId;
	}
	public function setTransmissionId($transmissionId) {
		$this->transmissionId = $transmissionId;
		return $this;
	}
	public function getTorrentName() {
		return $this->torrentName;
	}
	public function setTorrentName($torrentName) {
		$this->torrentName = $torrentName;
		return $this;
	}
	public function getTorrentFileLink() {
		return $this->torrentFileLink;
	}
	public function setTorrentFileLink($torrentFileLink) {
		$this->torrentFileLink = $torrentFileLink;
		return $this;
	}
	public function getPercentDone() {
		return $this->percentDone;
	}
	public function setPercentDone($percentDone) {
		$this->percentDone = $percentDone;
		return $this;
	}
	
	
}