<?php
namespace Morenware\DutilsBundle\Service;

use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;
use Monolog\Logger;

/** @Service("automatedsearch.service") */
class AutomatedSearchService {

    /** @DI\Inject("doctrine.orm.entity_manager")
     *  @var \Doctrine\ORM\EntityManager $em
     */
    public $em;

    /** @var \Doctrine\ORM\EntityRepository $repository */
    private $repository;
    private $entityClass;
    private $logger;

    /** @DI\Inject("transaction.service")
     * @var \Morenware\DutilsBundle\Util\TransactionService $transactionService
     */
    public $transactionService;

    private $transmissionConfigured = false;

    /**
     * @DI\InjectParams({
     *     "logger"           = @DI\Inject("monolog.logger"),
     *     "monitorLogger"	 = @DI\Inject("monolog.logger.monitor"),
     *     "entityClass"      = @DI\Inject("%morenware_dutils.automatedsearchconfig.class%")
     * })
     *
     */
    public function __construct(Logger $logger, Logger $monitorLogger, $entityClass) {

        $this->logger = $logger;
        $this->monitorLogger = $monitorLogger;
        $this->entityClass = $entityClass;
    }


    public function getRepository() {

        if ($this->repository == null) {
            $this->repository = $this->em->getRepository($this->entityClass);
        }

        return $this->repository;
    }

    public function create($automatedSearchConfig) {
        $this->em->persist($automatedSearchConfig);
        $this->em->flush();
    }

    public function persist($automatedSearchConfig) {
        $this->em->persist($automatedSearchConfig);
    }

    /** Non implicit transaction, needs one */
    public function merge($automatedSearchConfig) {
        $this->em->merge($automatedSearchConfig);
    }

    /* Implicit transaction version */
    public function update($automatedSearchConfig) {
        $this->em->merge($automatedSearchConfig);
        $this->em->flush();
        $this->em->clear();
    }

    public function find($id) {
        return $this->em->find($this->entityClass, $id);
    }

    public function getAll() {
        return $this->getRepository()->findAll();
    }

    public function getAllOrderedByDate() {
        return $this->getRepository()->findBy(array(), array('lastCheckedDate' => 'DESC'));
    }

    public function delete($automatedSearchConfig) {
        $this->em->remove($automatedSearchConfig);
        $this->em->flush();
        $this->em->clear();
    }












}