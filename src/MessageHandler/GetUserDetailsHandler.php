<?php


namespace App\MessageHandler;

use App\Message\GetUserDetailsCommand;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class GetUserDetailsHandler
{
    use DoctrineTrait;

    function __invoke(GetUserDetailsCommand $command)
    {
        $userRepository = $this->entityManager->getRepository('App:User');
        $user = $userRepository->find($command->getId());
        if(!$user) {

            throw new HttpException(404,"user not found by id: ". $command->getId());
        }
        return $user;
    }
}