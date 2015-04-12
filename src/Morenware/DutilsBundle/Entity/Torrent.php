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
	private $id;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $guid;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $title;
	
	/**
	 * @ORM\Column(type="string", length=200, nullable=true)
	 */
	private $torrentName;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	private $hash;
	
	/**
	 * @ORM\Column(name="magnet_link", type="string", length=300, nullable=true)
	 */
	private $magnetLink;
	
	/** 
	 * @ORM\Column(type="datetime", nullable=true) 
	 * 
	 */
	private $date;
	
	/**
	 * @ORM\Column(type="string", length=300, nullable=true)
	 */
	private $asset;
	
	/**
	 * @ORM\Column(type="string", length=300, nullable=true)
	 */
	private $state;
	
	/**
	 * @ORM\Column(name="content_type", type="string", length=300, nullable=true)
	 */
	private $contentType;
	
	
    // Path where this torrent is being downloaded	
	/**
	 * @ORM\Column(name="file_path", type="string", length=300, nullable=true)
	 */
	private $filePath;
	
	/**
	 * @ORM\Column(name="transmission_id", type="integer", nullable=true)
	 */
	private $transmissionId;
	
	/**
	 * @ORM\Column(name="origin", type="string", nullable=true)
	 */
	private $origin;

	/**
	 * @ORM\Column(name="torrent_file_link", type="string", nullable=true)
	 */
	private $torrentFileLink;
	
	/**
	 * @ORM\Column(name="percent_done", type="float", nullable=true)
	 */
	private $percentDone;
	
	
	// Path of this torrent file/s once it is finished/renamed in the destination library
	/**
	 * @ORM\Column(name="renamed_path", type="string", length=300, nullable=true)
	 */
	private $renamedPath;
	
	/**
	 * @ORM\Column(name="size", type="integer", nullable=true)
	 */
	private $size;
	
	/**
	 * @ORM\Column(name="seeds", type="integer", nullable=true)
	 */
	private $seeds;
	

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
	public function getRenamedPath() {
		return $this->renamedPath;
	}
	public function setRenamedPath($renamedPath) {
		$this->renamedPath = $renamedPath;
		return $this;
	}
	public function getSize() {
		return $this->size;
	}
	public function setSize($size) {
		$this->size = $size;
		return $this;
	}
	public function getSeeds() {
		return $this->seeds;
	}
	public function setSeeds($seeds) {
		$this->seeds = $seeds;
		return $this;
	}
	
// 	public function cmpSeeds($torrentA, $torrentB) {
   	 	
// 		$seedsA = $torrentA->getSeeds();
// 		$seedsB = "";
		
		
//    	 	if ($torrentA->getSeeds() === $torrentA->getSeeds()) {
//    	 		return 0;
//    	 	}
   	 	
//    	 	return ($torrentA->getSeeds() < $torrentB->getSeeds()) ? -1 : 1; 	
//    	 };
	
	
}