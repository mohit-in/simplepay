<?php

namespace App\Service;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UserApiProcessingService
{
    /**
     *  Function to process User Get Details API request.
     *
     * @param array $requestContent
     * @return object|null
     */
    public function processGetUserDetailsRequest($requestContent) {

        $userRepository = $this->entityManager->getRepository('App:User');
        $user = $userRepository->find($requestContent['id']);
        if(!$user) {
            throw new HttpException(404,"user not found by id: ". $requestContent['id']);
        }
        return $user;
    }

    /**
     *  Function to process User Delete API request.
     *
     * @param array $requestContent
     * @return object|null
     */
    public function processDeleteUserRequest($requestContent) {

        $userRepository = $this->entityManager->getRepository('App:User');
        $user = $userRepository->find($requestContent['id']);
        if(!$user) {    
            throw new HttpException(404,"user not found by id: ". $requestContent['id']);
        }
        return $user;
    }
}