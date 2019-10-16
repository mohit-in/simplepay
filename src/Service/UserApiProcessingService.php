<?php

namespace App\Service;

use App\Entity\User;

class UserApiProcessingService
{
    /**
     *  Function to process User Create API request.
     *
     *  @param array $requestContent
     *
     *  @return array
     */
    public function processCreateUserRequest($requestContent)
    {
        $user = new User();

        $user->setEmail("mohitks.in@gmail.com");
        $user->setName("Mohit Sharma");
        $user->setMobile("9999345816");
        $user->setPassword("mohit321");
        $user->setStatus("active");
        $user->setCreatedAt(new \Datetime);
        $user->setLastModifiedAt(new \Datetime);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
        
        return $user;
    }