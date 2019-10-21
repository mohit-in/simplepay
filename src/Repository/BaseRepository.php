<?php


namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class BaseRepository
 * @package App\Repository
 */
abstract class BaseRepository  extends ServiceEntityRepository
{
    /**
     * function to persist entity.
     *
     * @param $entity
     */
    public function save($entity) :void
    {
         $this->persist($entity);
    }

    /**
     * Function to remove entity.
     *
     * @param $entity
     */
    public  function remove($entity) :void
    {
        $this->remove($entity);
    }

    /**
     * Function to flush entity
     */
    public function commit() :void
    {
        $this->flush();
    }
}