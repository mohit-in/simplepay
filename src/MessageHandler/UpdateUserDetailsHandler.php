<?php


namespace App\MessageHandler;

use App\Message\UpdateUserDetailsCommand;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UpdateUserDetailsHandler
{
    use DoctrineTrait;

    public function __invoke(UpdateUserDetailsCommand $command)
    {
        $userRepository = $this->entityManager->getRepository('App:User');
        $user = $userRepository->find($command->getId());

        if(!$user) {
            throw new HttpException(404,"user not found by id: ". $command->getId());
        }
        if(!empty($command->getName())) {

            $user->setName($command->getName());
        }

        if(!empty($command->getMobile())) {
            $user->setName($command->getMobile());
        }

        if(!empty($command->getPassword())) {
            $user->setPassword($command->getPassword());
        }

        if (!empty($command->getStatus())){
            $user->setStatus($command->getStatus());
        }
        $this->unitOfWork->save($user);
        $this->unitOfWork->commit();

    }
}