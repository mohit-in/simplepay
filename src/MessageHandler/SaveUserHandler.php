<?php


namespace App\MessageHandler;

use App\Entity\User;
use App\Message\SaveUserCommand;

use App\MessageHandler\Traits\DoctrineUnitOfWorkTrait;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class SaveUserHandler
 * @package App\MessageHandler
 */
class SaveUserHandler
{
    use DoctrineUnitOfWorkTrait;

    /**
     * Handler to SaveUserCommand
     *
     * @param SaveUserCommand $command
     * @return User|object|null
     */
    public function __invoke(SaveUserCommand $command)
    {
        $userRepository = $this->entityManager->getRepository('App:User');

        if(!empty($command->getId())){

            $user = $userRepository->find($command->getId());

            if(empty($user)) {

                throw new HttpException(404,"user not found by id: ". $command->getId());
            }
        }
        else {

            if(!empty($userRepository->findOneByEmail($command->getEmail()))) {

                throw new HttpException(409,"user found by email: ". $command->getEmail());
            }

            $user = new User();
        }

        if(!empty($command->getName())) {

            $user->setName($command->getName());
        }

        if(!empty($command->getEmail())) {

            $user->setEmail($command->getEmail());
        }

        if(!empty($command->getMobile())) {

            $user->setMobile($command->getMobile());
        }

        if(!empty($command->getPassword())) {

            $user->setPassword($command->getPassword());
        }

        if (!empty($command->getStatus())){

            $user->setStatus($command->getStatus());
        }

        $this->unitOfWork->save($user);
        $this->unitOfWork->commit();

        return $user;
    }
}