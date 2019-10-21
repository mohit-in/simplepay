<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserApiProcessingService extends BaseService
{
    /**
     *  Function to process User Create API request.
     *
     * @param array $requestContent
     * @return array
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function processCreateUserRequest($requestContent)
    {   
        /* Checking user is already present or not by this email */
        $userRepository = $this->entityManager->getRepository('App:User');
        $user = $userRepository->findOneByEmail($requestContent['email']);
        
        if($user) {

            throw new HttpException(409,"User already present by ".$requestContent['email']." email");
        }

        $user = new User();
        $user->setEmail($requestContent['email']);
        $user->setName($requestContent['name']);
        $user->setMobile($requestContent['mobile']);
        $user->setPassword($requestContent['password']);
        $user->setStatus($requestContent['status']);
        $userRepository->save($user);
        $userRepository->commit($user);
        return $user;
    }

    /**
     *  Function to process User Get Details API request.
     *
     * @param array $requestContent
     * @return object|null
     */
    public function processGetUserDetailsRequest($requestContent) {

        $userRepository = $this->entityManager->getRepository('App:User');
        $user = $userRepository->find($requestContent['id']);
        if(!$user){

            throw new HttpException(404,"User not found by ". $requestContent['id']." id");
        }
        return $user;
    }

    /**
     *  Function to process User Delete API request.
     *
     * @param array $requestContent
     * @return object|null
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function processDeleteUserRequest($requestContent) {

        $userRepository = $this->entityManager->getRepository('App:User');
        $user = $userRepository->find($requestContent['id']);
        if(!$user) {    
            throw new HttpException(404,"User not found by ". $requestContent['id']." id");
        }
        $this->entityManager->remove($user);
        $this->entityManager->flush();
        return $user;
    }

    /**
     *  Function to process User Update API request.
     *
     * @param array $requestContent
     * @return object|null
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function processUpdateUserRequest($requestContent) {

        $userRepository = $this->entityManager->getRepository('App:User');
        $user = $userRepository->find($requestContent['id']);
        if(!$user) {
            throw new HttpException(404,"User not found by ". $requestContent['id']." id");
        }
        $user->setName($requestContent['name']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }
}