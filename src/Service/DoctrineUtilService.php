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
        
    public function SaveEntity($entity) {

        $this->submitEntity($entity,'persist');
    }
    public function deleteEntity($entity) {

        $this->submitEntity($entity,'remove');
    }
    public function deleteEntity($entity) {

        $this->submitEntity($entity,'remove');
    }
    private function submitEntity($entity, $action) {

        try {

            if($action == 'persist') {

                $this->entityManager->persist($entity);
            }
            elseif($action == 'remove') {

                $this->entityManager->remove($entity);   
            }
            $this->entityManager->flush();    
            return $entity;
        }
        catch (\Exception $ex) {

            $this->logger->error(__FUNCTION__.' Function failed due to Error :'. $ex->getMessage());
            throw new HttpException(500, ErrorConstants::INTERNAL_ERR);
        }
    }
}