<?php
namespace Morenware\DutilsBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="mediacenter_settings")
 *
 */
class MediaCenterSettings {
	
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", length=200, nullable=true)
	 */
	protected $description;
	
	/**
	 * @ORM\Column(name="base_downloads_path", type="string", length=50)
	 */
	protected $baseDownloadsPath;
	
	/**
	 * @ORM\Column(name="base_library_path", type="string", length=50)
	 */
	protected $baseLibraryPath;
	
	/**
	 * @ORM\Column(name="is_remote", type="boolean", length=1, nullable=true)
	 */
	protected $isRemote;
	
	/**
	 * @ORM\Column(name="xbmc_host_or_ip", type="string", length=30, nullable=true)
	 */
	protected $xbmcHostOrIp;
	
	/**
	 * @ORM\Column(name="processing_temp_path", type="string", length=50)
	 */
	protected $processingTempPath;
	
	/**
	 * @ORM\Column(name="transcode_temp_path", type="string", length=50, nullable=true)
	 */
	protected $transcodeTempPath;
	
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}
	public function getBaseDownloadsPath() {
		return $this->baseDownloadsPath;
	}
	public function setBaseDownloadsPath($baseDownloadsPath) {
		$this->baseDownloadsPath = $baseDownloadsPath;
		return $this;
	}
	public function getBaseLibraryPath() {
		return $this->baseLibraryPath;
	}
	public function setBaseLibraryPath($baseLibraryPath) {
		$this->baseLibraryPath = $baseLibraryPath;
		return $this;
	}
	public function getIsRemote() {
		return $this->isRemote;
	}
	public function setIsRemote($isRemote) {
		$this->isRemote = $isRemote;
		return $this;
	}
	public function getXbmcHostOrIp() {
		return $this->xbmcHostOrIp;
	}
	public function setXbmcHostOrIp($xbmcHostOrIp) {
		$this->xbmcHostOrIp = $xbmcHostOrIp;
		return $this;
	}
	public function getProcessingTempPath() {
		return $this->processingTempPath;
	}
	public function setProcessingTempPath($processingTempPath) {
		$this->processingTempPath = $processingTempPath;
		return $this;
	}
	public function getTranscodeTempPath() {
		return $this->transcodeTempPath;
	}
	public function setTranscodeTempPath($transcodeTempPath) {
		$this->transcodeTempPath = $transcodeTempPath;
		return $this;
	}
}