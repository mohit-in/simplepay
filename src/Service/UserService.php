<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\ORMException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

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
     * @var ContainerInterface
     */
    private $container;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param ContainerInterface $container
     */
    public function __construct(UserRepository $userRepository, ContainerInterface $container)
    {
        $this->userRepository = $userRepository;
        $this->container = $container;
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
     * Function to Fetch User using Id.
     * @param $email
     * @param $password
     * @return User
     */
    public function findUserByEmailPassword($email, $password): User
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);
        if (!$user) {
            throw new NotFoundHttpException(sprintf('User does not exists with Email: %s', $email));
        }
        $isValid = $this->container->get('security.password_encoder')
            ->isPasswordValid($user, $password);
        if (!$isValid) {
            throw new BadCredentialsException(sprintf("Invalid password"));
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
