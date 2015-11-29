<?php
namespace Morenware\DutilsBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;


/**
 * 
 * @ORM\Entity
 * @ORM\Table(name="torrent_search_result")
 * 
 */
class TorrentSearchResult {
	
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $title;

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
	 * @ORM\Column(name="date_found", type="datetime", nullable=true) 
	 * 
	 */
	private $dateFound;
	
	/**
	 * @ORM\Column(type="string", length=300, nullable=true)
	 */
	private $state;
	
	/**
	 * @ORM\Column(name="content_type", type="string", length=300, nullable=true)
	 */
	private $contentType;
	
	
	/**
	 * @ORM\Column(name="origin", type="string", nullable=true)
	 */
	private $origin;

	/**
	 * @ORM\Column(name="torrent_file_link", type="string", nullable=true)
	 */
	private $torrentFileLink;
	
	
	/**
	 * @ORM\Column(name="size", type="integer", nullable=true)
	 */
	private $size;
	
	/**
	 * @ORM\Column(name="seeds", type="integer", nullable=true)
	 */
	private $seeds;

	/**
	 * @ORM\Column(name="search_hash", type="string", nullable=true)
	 */
	private $hash;


    /**
     * @ORM\Column(name="lang", type="string", nullable=true)
     */
    private $language;


    /**
     * @ORM\Column(name="site_id", type="string", nullable=true)
     */
    private $siteId;

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return mixed
     */
    public function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * @param mixed $siteId
     */
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;
    }


	/**
	 * @return mixed
	 */
	public function getDateFound()
	{
		return $this->dateFound;
	}

	/**
	 * @param mixed $dateFound
	 */
	public function setDateFound($dateFound)
    {
        $this->dateFound = $dateFound;
    }

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

	public function getOrigin() {
		return $this->origin;
	}
	public function setOrigin($origin) {
		$this->origin = $origin;
		return $this;
	}

	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	public function getTorrentFileLink() {
		return $this->torrentFileLink;
	}
	public function setTorrentFileLink($torrentFileLink) {
		$this->torrentFileLink = $torrentFileLink;
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
	
}