<?php
namespace Morenware\DutilsBundle\Service\Search;

class SearchWebsite {
	
	private $name;

	private $mainUrl;
	
	private $siteId;
	
	// Can be AGE, FULL_DATE, DATE
	private $torrentDateType;
	
	// MAIN_DETAIL or just LIST
	private $structureType;
	
	private $searchUrl;
	
	// Selector which gives the rows with all the data from a search
	private $torrentMainResultsFilterString;
	
	// Selector which gives all the torrent titles
	private $torrentTitlesFilterString;
	
	// Selector which gives all the torrent file links, if present
	private $torrentFilesFilterString;
	
	// Selector which gives all the magnet links, if present
	private $torrentMagnetLinksFilterString;
	
	// Selector which gives most of the rest of torrent attributes: seeds, date, size...
	private $torrentAttributesFilterString;
	
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