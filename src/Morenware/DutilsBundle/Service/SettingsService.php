<?php
namespace Morenware\DutilsBundle\Service;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\Common\Persistence\ObjectManager;

/** @Service("settings.service") */
class SettingsService {
	
	/** @DI\Inject("doctrine.orm.entity_manager") */
	public $em;
	
	private $transmissionRepository;
	private $mediacenterRepository;
	
	private $transmissionSettingsClass;
	private $mediacenterSettingsClass;
	
	
	private $logger;

	
	/**
	 * @DI\InjectParams({
	 *     "logger" = @DI\Inject("logger"),
	 *     "transmissionSettingsClass" = @DI\Inject("%morenware_dutils.transmissionsettings.class%"),
	 *     "mediacenterSettingsClass" = @DI\Inject("%morenware_dutils.mediacentersettings.class%")
	 * })
	 *
	 */
	public function __construct($logger, $transmissionSettingsClass, $mediacenterSettingsClass) {
	
		$this->logger = $logger;
		$this->mediacenterSettingsClass = $mediacenterSettingsClass;
		$this->transmissionSettingsClass = $transmissionSettingsClass;
	}
	
	public function getRepository($entityClass) {
		return $this->em->getRepository($entityClass);
	}
	
	public function getTransmissionRepository() {
	 return $this->getRepository($this->transmissionSettingsClass);
	}
	
	public function getMediacenterRepository() {
		return $this->getRepository($this->mediacenterSettingsClass);
	}
	
	public function create($entity) {
		$this->em->persist($entity);
		$this->em->flush();
	}

	public function update($entity) {
		$this->em->merge($entity);
		$this->em->flush();
	}
	
	public function delete($entity) {
		$this->em->remove($entity);
		$this->em->flush();
	}

	public function findTransmissionSettings($id) {
		return $this->getTransmissionRepository()->find($id);
	}
	
	public function findMediacenterSettings($id) {
		return $this->getMediacenterRepository()->find($id);
	}
	
	public function getDefaultMediacenterSettings() {
		return $this->getMediacenterRepository()->find(1);
	}
	
	public function getDefaultTransmissionSettings() {
		return $this->getTransmissionRepository()->find(1);
	}
	
	
		
	
	
	
	
	
	
	
	
	
}