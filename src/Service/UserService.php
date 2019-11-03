<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UserService
 * @package App\Service
 */
class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Function to Fetch User using Id.
     * @param int $id
     *
     * @return User
     */
    public function findUserById(int $id): User
    {
        $user = $this->userRepository->find($id);

        // check if user does not exists then send not found
        if (!$user) {
            throw new NotFoundHttpException(sprintf('User: #%d not found', $id));
        }

        return $user;
    }

    /**
     * Function to delete User.
     *
     * @param int $id
     *
     * @return User
     * @throws ORMException
     */
    public function deleteUser(int $id): User
    {
        /** @var User $user */
        $user = $this->findUserById($id);

        // Deleting User.
        $this->userRepository->remove($user);

        return $user;
    }
}
