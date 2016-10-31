<?php
namespace Morenware\DutilsBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="search_website")
 *
 */
class SearchWebsite {

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(name="site_name", type="string", length=200)
	 */
	private $name;

	/**
	 * @ORM\Column(name="main_url", type="string", length=200)
	 */
	private $mainUrl;

    /**
     * @ORM\Column(name="site_id", type="string", length=10)
     */
	private $siteId;

	
	// Can be AGE, FULL_DATE, DATE
    /**
     * @ORM\Column(name="torrent_date_type", type="string", length=20)
     */
    private $torrentDateType;


	// MAIN_DETAIL or just LIST
    /**
     * @ORM\Column(name="structure_type", type="string", length=20)
     */
    private $structureType;

    /**
     * @ORM\Column(name="search_url", type="string", length=200, nullable=true)
     */
	private $searchUrl;
	
	// Selector which gives the rows with all the data from a search
    /**
     * @ORM\Column(name="torrent_main_results_filter_string", type="string", length=200, nullable=true)
     */
	private $torrentMainResultsFilterString;
	
	// Selector which gives all the torrent titles
    /**
     * @ORM\Column(name="torrent_titles_filter_string", type="string", length=200, nullable=true)
     */
	private $torrentTitlesFilterString;
	
	// Selector which gives all the torrent file links, if present
    /**
     * @ORM\Column(name="torrent_files_filter_string", type="string", length=200, nullable=true)
     */
	private $torrentFilesFilterString;
	
	// Selector which gives all the magnet links, if present
    /**
     * @ORM\Column(name="torrent_magnet_links_filter_string", type="string", length=200, nullable=true)
     */
	private $torrentMagnetLinksFilterString;
	
	// Selector which gives most of the rest of torrent attributes: seeds, date, size...
    /**
     * @ORM\Column(name="torrent_attribute_filter_string", type="string", length=200, nullable=true)
     */
	private $torrentAttributesFilterString;

    /**
     * @ORM\Column(name="main_language", type="string", length=5)
     */
    private $mainLanguage;

    /**
     * @return mixed
     */
    public function getMainLanguage()
    {
        return $this->mainLanguage;
    }

    /**
     * @param mixed $mainLanguage
     */
    public function setMainLanguage($mainLanguage)
    {
        $this->mainLanguage = $mainLanguage;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

	public function getName() {
		return $this->name;
	}
	
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	
	public function getMainUrl() {
		return $this->mainUrl;
	}
	
	public function setMainUrl($mainUrl) {
		$this->mainUrl = $mainUrl;
		return $this;
	}
	
	public function getSiteId() {
		return $this->siteId;
	}
	
	public function setSiteId($siteId) {
		$this->siteId = $siteId;
		return $this;
	}
	
	public function getTorrentDateType() {
		return $this->torrentDateType;
	}
	
	public function setTorrentDateType($torrentDateType) {
		$this->torrentDateType = $torrentDateType;
		return $this;
	}
	
	public function getStructureType() {
		return $this->structureType;
	}
	
	public function setStructureType($structureType) {
		$this->structureType = $structureType;
		return $this;
	}
	
	public function getSearchUrl() {
		return $this->searchUrl;
	}
	
	public function setSearchUrl($searchUrl) {
		$this->searchUrl = $searchUrl;
		return $this;
	}
	
	public function getTorrentTitlesFilterString() {
		return $this->torrentTitlesFilterString;
	}
	
	public function setTorrentTitlesFilterString($torrentTitlesFilterString) {
		$this->torrentTitlesFilterString = $torrentTitlesFilterString;
		return $this;
	}
	
	public function getTorrentFilesFilterString() {
		return $this->torrentFilesFilterString;
	}
	
	public function setTorrentFilesFilterString($torrentFilesFilterString) {
		$this->torrentFilesFilterString = $torrentFilesFilterString;
		return $this;
	}
	
	public function getTorrentMagnetLinksFilterString() {
		return $this->torrentMagnetLinksFilterString;
	}
	
	public function setTorrentMagnetLinksFilterString($torrentMagnetLinksFilterString) {
		$this->torrentMagnetLinksFilterString = $torrentMagnetLinksFilterString;
		return $this;
	}
	
	public function getTorrentAttributesFilterString() {
		return $this->torrentAttributesFilterString;
	}
	
	public function setTorrentAttributesFilterString($torrentAttributesFilterString) {
		$this->torrentAttributesFilterString = $torrentAttributesFilterString;
		return $this;
	}
	public function getTorrentMainResultsFilterString() {
		return $this->torrentMainResultsFilterString;
	}
	public function setTorrentMainResultsFilterString($torrentMainResultsFilterString) {
		$this->torrentMainResultsFilterString = $torrentMainResultsFilterString;
		return $this;
	}
	
}