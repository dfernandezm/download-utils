<?php
namespace Morenware\DutilsBundle\Entity;

class Instance {
	
	private $id;
	private $name;
	private $osFamily;
	private $osName;
	private $sshPort;
	private $description;
	
	public function __construct() {
		
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	
	public function getOsFamily() {
		return $this->osFamily;
	}

	public function setOsFamily($osFamily) {
		$this->osFamily = $osFamily;
	}

	public function getOsName() {
		return $this->osName;
	}
	
	public function setOsName($osName) {
		$this->osName = $osName;
	}
	
	public function getSshPort() {
		return $this->sshPort;
	}
	
	public function setSshPort($sshPort) {
		$this->sshPort = $sshPort;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
	}
	
	
}
