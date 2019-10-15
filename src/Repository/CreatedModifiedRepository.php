<?php

namespace App\Repository;

use App\Entity\CreatedModified;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CreatedModified|null find($id, $lockMode = null, $lockVersion = null)
 * @method CreatedModified|null findOneBy(array $criteria, array $orderBy = null)
 * @method CreatedModified[]    findAll()
 * @method CreatedModified[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreatedModifiedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreatedModified::class);
    }

    // /**
    //  * @return CreatedModified[] Returns an array of CreatedModified objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CreatedModified
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
