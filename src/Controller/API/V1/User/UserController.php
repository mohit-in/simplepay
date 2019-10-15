<?php

namespace App\Controller\API\V1\User;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController; 
use Symfony\Component\HttpFoundation\Request;


class UserController extends FOSRestController
{ 
    /**
     * 
     * @Rest\Get("/user")
     * @param Request $request
     * @return View
     */
    public function postUser(Request $request): View
    {
        print_r("expression");exit;
        // $user = new User();
        // $user->setName($request->post('name'));
        // $user->setEmail($request->post('email'));
        // $user->setMobile($request->post('mobile'));
        // $this->entityManager->persist($user);
        // $this->entityManager->flush();
        return true;
        #return View::create($user, Response::HTTP_CREATED);
    }
}