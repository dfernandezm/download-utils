<?php
namespace Morenware\DutilsBundle\Util;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Morenware\DutilsBundle\Entity\Instance;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\DiExtraBundle\Annotation\Service;

/** @Service("transaction.service") */
class TransactionService {

	/** @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager $em
     */
	public $em;
	
	/** @DI\Inject("monolog.logger")
     * @var \Monolog\Logger $logger
     */
	public $logger;
	
	
	/**
     * This is not used at the moment, look at executeInTransactionWithRetryUsingProvidedEm
     *
	 * Executes the runnable block in a transaction using the injected entity manager, which is passed to the block
	 * @param unknown $runnable
	 * @throws Exception
	 * @return unknown
	 */
	public function executeInTransaction(callable $runnable) {
		// If there is already a transaction in progress then this
		// sub-transaction can only be attempted once ...
		if ($this->em->getConnection()->isTransactionActive()) {
			
			$this->logger->warn("There is already one transaction running so executing in it");
			$runnable($this->em);
			
		} else {
			
			$this->em->beginTransaction();
			try {
				$result = $runnable($this->em);
				$this->em->flush();
				$this->em->commit();
				return $result;
			} catch (\Exception $e) {
				$this->em->rollback();
				$this->em->clear();
				$this->logger->error("Error occurred in transaction -- ", $e);	
				throw $e;
			}
		}	
	}
	
	public function executeInTransactionWithRetry($runnable) {
	
		$success = false;
		$retryCount = 0;
		$exception = null;
		
		while (!$success && $retryCount < 5) {
			$this->em->beginTransaction();
			try {
				$runnable($this->em);
				$this->em->flush();
				$this->em->commit();
				$success = true;		
			} catch (\Exception $e) {
				$this->logger->warn("Error executing transaction -- retrying", $e);
				$this->em->rollback();
				$this->em->clear();
				$exception = $e;
				$retryCount++;
			}		
		}
	
		if (!$success) {
			$this->logger->error("Error executing transaction after 5 tries -- giving up", $exception);
			throw $exception;
		}
	}
	
	
	/**
	 * Executes runnable in the context of a transaction created through the Entity Manager passed as parameter.
	 * The transaction retries 5 times and gives up after that throwing the last exception supplied
	 * 
	 * @param unknown $em
	 * @param unknown $runnable
	 * @throws Exception
	 */
	public function executeInTransactionWithRetryUsingProvidedEm(EntityManager $em, callable $runnable) {
	
		$success = false;
		$retryCount = 0;
		$exception = null;
	
		while (!$success && $retryCount < 5) {
			$em->beginTransaction();
			try {
				$runnable();
				$em->flush();
				$em->commit();
				$success = true;
			} catch (\Exception $e) {
				$this->logger->warn("Error executing transaction -- retrying " . $e->getMessage() . ", trace: " . $e->getTraceAsString());
				$em->rollback();
				$em->clear();
				$exception = $e;
				$retryCount++;
			}
		}
	
		if (!$success) {
			$this->logger->error("Error executing transaction after 5 tries -- giving up -- " . $exception->getMessage(), $exception->getTrace());
			throw $exception;
		}
	}
}