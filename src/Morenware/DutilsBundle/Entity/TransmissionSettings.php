<?php
namespace Morenware\DutilsBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;
/**
 *
 * @ORM\Entity
 * @ORM\Table(name="transmission_settings")
 *
 */
class TransmissionSettings {
	
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
	 * @ORM\Column(name="ip_or_host", type="string", length=30, nullable=true)
	 */
	protected $ipOrHost;
	
	/**
	 * @ORM\Column(type="integer", length=10, nullable=true)
	 */
	protected $port;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $username;
	
	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $password;
	
	/**
	 * @ORM\Column(name="base_downloads_dir", type="string", length=100, nullable=true)
	 */
	protected $baseDownloadsDir;
	
	
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
	public function getIpOrHost() {
		return $this->ipOrHost;
	}
	public function setIpOrHost($ipOrHost) {
		$this->ipOrHost = $ipOrHost;
		return $this;
	}
	public function getPort() {
		return $this->port;
	}
	public function setPort($port) {
		$this->port = $port;
		return $this;
	}
	public function getUsername() {
		return $this->username;
	}
	public function setUsername($username) {
		$this->username = $username;
		return $this;
	}
	public function getPassword() {
		return $this->password;
	}
	public function setPassword($password) {
		$this->password = $password;
		return $this;
	}
	public function getBaseDownloadsDir() {
		return $this->baseDownloadsDir;
	}
	public function setBaseDownloadsDir($baseDownloadsDir) {
		$this->baseDownloadsDir = $baseDownloadsDir;
		return $this;
	}
}