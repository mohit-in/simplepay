<?php


namespace App\MessageHandler;


use App\Message\DeleteUserAccountCommand;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DeleteUserAccountHandler
{
    use DoctrineTrait;
    public function __invoke(DeleteUserAccountCommand $command)
    {
        $userRepository = $this->entityManager->getRepository('App:User');
        $user = $userRepository->find($command->getId());
        if(!$user) {
            throw new HttpException(404,"user not found by id: ".$command->getId());
        }
        $this->unitOfWork->remove($user);
        $this->unitOfWork->commit();
        return $user;
    }
}