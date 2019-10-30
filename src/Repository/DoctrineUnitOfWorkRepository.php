<?php


namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DoctrineUnitOfWorkRepository
 * @package App\Repository
 */
class DoctrineUnitOfWorkRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * DoctrineUnitOfWordRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * funtion to save entity
     *
     * @param  $entity
     */
    public function save($entity): void
    {

        $this->entityManager->persist($entity);
    }

    /**
     * funtion to remove entity
     *
     * @param $entity
     */
    public function remove($entity): void
    {

        $this->entityManager->remove($entity);
    }

    /**
     * funtion to commit Unit of Work
     */
    public function commit(): void
    {
        $this->entityManager->flush();
    }

}