<?php


namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;

/**
 * Class DoctrineUnitOfWorkRepository
 * @package App\Repository
 */
class DoctrineUnitOfWorkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entity = '')
    {
        parent::__construct($registry, $entity);
    }

    /**
     * Function to save entity
     *
     * @param $entity
     * @param $flush
     *
     * @throws ORMException
     */
    public function save($entity, $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->commit();
        }
    }

    /**
     * Function to remove entity
     *
     * @param $entity
     * @param $flush
     *
     * @throws ORMException
     */
    public function remove($entity, $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->commit();
        }
    }

    /**
     * Function to commit Unit of Work
     *
     * @throws ORMException
     */
    public function commit(): void
    {
        $this->getEntityManager()->flush();
    }
}
