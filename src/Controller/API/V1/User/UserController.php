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
        $requestContent = $request->request->all();

        $respone = array();
        $respone = $this->container
                        ->get('user_api_processing_service')
                        ->processCreateUserRequest($requestContent);
                        
        return View::create($respone, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get("/{id}")
     * @param Request $request
     * @return View
     */
    public function getUserDetails(Request $request,$id)
    {   
        $requestContent = array();
        $requestContent['id'] = $id;
        
        $respone = array();
        $respone = $this->container
                        ->get('user_api_processing_service')
                        ->processgetUserDetailsRequest($requestContent);
        return View::create($respone, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete("/{id}")
     * @param Request $request
     * @return View
     */
    public function deleteUser(Request $request,$id)
    {   
        $requestContent = array();
        $requestContent['id'] = $id;

        $respone = array();
        $respone = $this->container
                        ->get('user_api_processing_service')
                        ->processDeleteUserRequest($requestContent);
        return View::create($respone, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Patch("/{id}")
     * @param Request $request
     * @return View
     */
    public function UpdateUserDetails(Request $request,$id)
    {   
            
        parse_str($request->getContent(),$requestContent);


        print_r($requestContent);exit;



        $requestContent = array();
        $requestContent['id'] = $id;
        $respone = array();
        $respone = $this->container
                        ->get('user_api_processing_service')
                        ->processDeleteUserRequest($requestContent);
        return View::create($respone, Response::HTTP_CREATED);
    }
}