<?php

namespace App\MessageHandler;

use App\Entity\User;
use App\Message\RegisterUserCommand;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RegisterUserHandler
{
    use DoctrineTrait;

    public function __invoke(RegisterUserCommand $command)
    {
        /* Checking user is already present or not by this email */
        $userRepository = $this->entityManager->getRepository('App:User');
        $user = $userRepository->findOneByEmail($command->getEmail());

        /* Throw Exception if user already present */
        if ($user) {

            throw new ConflictHttpException(409, "User already present by " . $command->getEmail() . " email");
        }
        $user = new User();
        $user->setName($command->getName());
        $user->setEmail($command->getEmail());
        $user->setMobile($command->getMobile());
        $user->setPassword($command->getPassword());

        $this->unitOfWork->save($user);
        $this->unitOfWork->commit();
        return $user;
    }
}