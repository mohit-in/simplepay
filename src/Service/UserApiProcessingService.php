<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserApiProcessingService extends BaseService
{
    /**
     *  Function to process User Create API request.
     *
     *  @param array $requestContent
     *  @return array
     */
    public function processCreateUserRequest($requestContent)
    {   
        //print_r($requestContent);exit;
        $userRepository = $this->entityManager->getRepository('App:User');
        $user = $userRepository->findOneByEmail($requestContent['email']);
        if($user) { 

            throw new HttpException(200,"User already created by ".$requestContent['email']." email");
        }
        $user = new User();
        $user->setEmail($requestContent['email']);
        $user->setName($requestContent['name']);
        $user->setMobile($requestContent['mobile']);
        $user->setPassword($requestContent['password']);
        $user->setStatus($requestContent['status']);
        $user->setCreatedAt(new \Datetime);
        $user->setLastModifiedAt(new \Datetime);
        
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }
    /**
     *  Function to process User Get Details API request.
     *
     *  @param array $requestContent
     *  @return array
     */
    public function processgetUserDetailsRequest($requestContent) {

        $userRepository = $this->entityManager->getRepository('App:User');
        $user = $userRepository->findByMobile("99993345816");
        if(!$user) {

            throw new HttpException(404,"User not found by ". $requestContent['id']." id");
        }
        return $user;
    }
}