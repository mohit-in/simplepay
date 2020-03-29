<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends  DoctrineUnitOfWorkRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function findTransactionList(array $parameters = [])
    {

        $qb = $this->createQueryBuilder('t');
        if(isset($parameters['senderId'])) {
            $qb->andWhere('t.senderId = :senderId')
                ->setParameter('senderId', $parameters['senderId']);
        }
        if(isset($parameters['receiverId'])) {
            $qb->andWhere('t.receiverId = :receiverId')
                ->setParameter('receiverId', $parameters['receiverId']);
        }
        if (isset($parameters['orderBy'])) {
            foreach ($parameters['orderBy'] as $key => $value) {
                $qb->addOrderBy('t.'.$key, $value);
            }
        }
        if(isset($parameters['offset'])) {
            $qb->setFirstResult($parameters['offset']);
        }
        if(isset($parameters['limit'])) {
            $qb->setMaxResults($parameters['limit']);
        }

        return $qb->getQuery()
            ->getResult();

    }
}
