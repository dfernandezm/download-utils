<?php
namespace Morenware\DutilsBundle\Entity;

class Instance {
	
	private $id;
	private $name;
	private $osFamily;
	private $osName;
	private $sshPort;
	private $description;
	
	
	
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
		return $this;
	}

	public function getOsName() {
		return $this->osName;
	}
	
	public function setOsName($osName) {
		$this->osName = $osName;
		return $this;
	}
	
	public function getSshPort() {
		return $this->sshPort;
	}
	
	public function setSshPort($sshPort) {
		$this->sshPort = $sshPort;
		return $this;
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
		return $this;
	}
	
	
}
