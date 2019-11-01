<?php

namespace App\Service;

use App\Repository\DoctrineUnitOfWorkRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UserApiProcessingService
 * @package App\Service
 */
class UserApiProcessingService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var DoctrineUnitOfWorkRepository
     */
    private $unitOfWork;

    /**
     * UserApiProcessingService constructor.
     * @param UserRepository $userRepository
     * @param DoctrineUnitOfWorkRepository $unitOfWork
     */
    public function __construct(UserRepository $userRepository, DoctrineUnitOfWorkRepository $unitOfWork)
    {
        $this->userRepository = $userRepository;
        $this->unitOfWork = $unitOfWork;
    }


    /**
     *  Function to process User Get Details API request.
     *
     * @param array $requestContent
     * @return object|null
     */
    public function processGetUserDetailsRequest($requestContent)
    {
        $user = $this->userRepository->find($requestContent['id']);

        if (empty($user)) {

            throw new NotFoundHttpException( "user not found by id: " . $requestContent['id']);
        }

        return $user;
    }

    /**
     *  Function to process User Delete API request.
     *
     * @param array $requestContent
     * @return object|null
     */
    public function processDeleteUserRequest($requestContent)
    {

        $user = $this->userRepository->find($requestContent['id']);

        if (!$user) {

            throw new NotFoundHttpException("user not found by id: " . $requestContent['id']);
        }

        $this->unitOfWork->remove($user);
        $this->unitOfWork->commit();

        return $user;
    }
}