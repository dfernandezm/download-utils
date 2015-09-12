<?php
namespace Morenware\DutilsBundle\Service;
use Doctrine\Common\Collections\ArrayCollection;

use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;
use Monolog\Logger;

/** @Service("searchwebsite.service") */
class SearchWebsiteService {

    /** @DI\Inject("doctrine.orm.entity_manager")
     *  @var \Doctrine\ORM\EntityManager $em
     */
    public $em;

    /** @var \Doctrine\ORM\EntityRepository $repository */
    private $repository;
    private $entityClass;

    /**
     * @DI\InjectParams({
     *     "logger"           = @DI\Inject("monolog.logger"),
     *     "entityClass"      = @DI\Inject("%morenware_dutils.searchwebsite.class%")
     * })
     *
     */
    public function __construct(Logger $logger, $entityClass) {

        $this->logger = $logger;
        $this->entityClass = $entityClass;
    }

    public function getRepository() {

        if ($this->repository == null) {
            $this->repository = $this->em->getRepository($this->entityClass);
        }

        return $this->repository;
    }

    public function create($searchWebsite) {
        $this->em->persist($searchWebsite);
        $this->em->flush();
    }

    public function merge($searchWebsite) {
        $this->em->merge($searchWebsite);
        $this->em->flush();
    }

    public function find($id) {
        return $this->em->find($this->entityClass, $id);
    }

    public function getAll() {
        return $this->getRepository()->findAll();
    }

    public function getAllOrdered() {
        return $this->getRepository()->findBy(array(), array('siteId' => 'DESC'));
    }

    public function findByLanguage($language) {
        return $this->getRepository()->findBy(array('mainLanguage' => $language));
    }

    public function findBySiteId($siteId) {
        return $this->getRepository()->findOneBy(array('siteId' => $siteId));
    }

    public function delete($searchWebsite) {
        $this->em->remove($searchWebsite);
        $this->em->flush();
        $this->em->clear();
    }

}