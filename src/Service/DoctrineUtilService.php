<?php

namespace App\Service;
    
use Doctrine\ORM\EntityManager;

abstract class DoctrineUtilService
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    
    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager): void
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }




    public function save($entity, $flush = 0) {

        $this->submit($entity, $flush, 'persist');
    }
    public function remove($entity,$flush = 0) {

        $this->submit($entity,$flush,'remove');
    }
    private function submit($entity, $action) {

        try {

            if($action == 'persist') {

                $this->entityManager->persist($entity);
            }
            elseif($action == 'remove') {

                $this->entityManager->remove($entity);   
            }
            if($flush == 1) {

                $this->entityManager->flush();    
            }
                
            return $entity;
        }
        catch (\Exception $ex) {

            $this->logger->error(__FUNCTION__.' Function failed due to Error :'. $ex->getMessage());
            throw new HttpException(500, ErrorConstants::INTERNAL_ERR);
        }
    }
}