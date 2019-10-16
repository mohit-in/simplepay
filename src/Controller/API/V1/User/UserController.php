<?php

namespace App\Controller\API\V1\User;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Application\Service\UserApiProcessingService;
use FOS\RestBundle\View\View;

class UserController extends FOSRestController
{ 
    /**
     * @Rest\Post("/")
     * @param Request $request
     * @return View
     */
    public function createUser(Request $request)
    {   
        $respone = array();
        $respone = $this->container
                        ->get('user_api_processing_service')
                        ->processCreateUserRequest($request->request->all());
        return View::create($respone, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get("/{id}")
     * @param Request $request
     * @return View
     */
    public function getUserDetails(Request $request)
    {   
        $respone = array();
        $respone = $this->container
                        ->get('user_api_processing_service')
                        ->processCreateUserRequest();
        return View::create($respone, Response::HTTP_CREATED);
    }
}