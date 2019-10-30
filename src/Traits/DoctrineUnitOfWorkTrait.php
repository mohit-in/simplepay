<?php


namespace App\Traits;


use App\Repository\DoctrineUnitOfWorkRepository;
use Doctrine\ORM\EntityManagerInterface;

trait DoctrineUnitOfWorkTrait
{
    private $entityManager;
    /**
     * RegisterUserHandler constructor.
     * @param $entityManager
     */

    /**
     * @var DoctrineUnitOfWorkRepository
     */
    private $unitOfWork;

    public function __construct(EntityManagerInterface $entityManager, DoctrineUnitOfWorkRepository $unitOfWork)
    {
        $this->entityManager = $entityManager;
        $this->unitOfWork = $unitOfWork;
    }
}