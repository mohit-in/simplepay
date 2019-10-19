<?php

namespace App\Controller\API\V1\User;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class UserController extends FOSRestController
{ 
    /**
     * Function to handle User Create API request
     * @Rest\Post("/")
     * @param Request $request
     * @return View
     */
    public function createUser(Request $request)
    {   
        $requestContent = $request->request->all();

        $response = $this->container
                        ->get('user_api_processing_service')
                        ->processCreateUserRequest($requestContent);

        return View::create($response, Response::HTTP_CREATED);

    }

    /**
     * Function to GET the details of user by using user id.
     * @Rest\Get("/{id}")
     * @param Request $request
     * @param $id
     * @return View
     */
    public function getUserDetails(Request $request,$id)
    {   
        $requestContent = array();
        $requestContent['id'] = $id;

        $respone = $this->container
                        ->get('user_api_processing_service')
                        ->processgetUserDetailsRequest($requestContent);
        return View::create($respone, Response::HTTP_OK);
    }

    /**
     * Function to handle User Delete API request
     * @Rest\Delete("/{id}")
     * @param Request $request
     * @param $id
     * @return View
     */
    public function deleteUser(Request $request,$id)
    {   
        $requestContent = array();
        $requestContent['id'] = $id;

        $response = $this->container
                        ->get('user_api_processing_service')
                        ->processDeleteUserRequest($requestContent);
        return View::create($response, Response::HTTP_OK);
    }

    /**
     * Function to handle User Update API request
     * @Rest\Patch("/{id}")
     * @param Request $request
     * @param $id
     * @return View
     */
    public function UpdateUserDetails(Request $request,$id)
    {   
            
        parse_str($request->getContent(),$requestContent);
        $requestContent['id'] = $id;
        $response = $this->container
                        ->get('user_api_processing_service')
                        ->processUpdateUserRequest($requestContent);
        return View::create($response, Response::HTTP_OK);
    }
}