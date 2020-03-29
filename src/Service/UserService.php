<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
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
        $isValid = $this->passwordEncoder
            ->isPasswordValid($user, $password);
        if (!$isValid) {
            throw new BadCredentialsException(sprintf('Invalid password'));
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
