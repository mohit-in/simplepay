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
     * @Rest\Post("/")
     * @param Request $request
     * @return View
     */
    public function createUser(Request $request)
    {   
        $respone = array();
        $respone = $this->container
                        ->get('user_api_processing_service')
                        ->processCreateUserRequest();
        return View::create($respone, Response::HTTP_CREATED);
    }





    /**
     * @Rest\Patch("/{id}")
     * @param Request $request
     * @return View
     */
    public function updateUser(Request $request, $id):View
    {   
        //$content = $request->patch("name");
        
        print_r($request->headers->get("name"));exit;
        print_r($request->request->all());exit
        print_r($content);exit;    
    }

    /**
     * @Rest\Delete("/{id}")
     * @param Request $request
     * @return View
     */
    public function deleteUser(Request $request, $id): View 
    {
        
    }

    /**
     * @Rest\Get("/{id}")
     * @param Request $request
     * @return View
     */
    public function getUserDetails(Request $request, $id): View 
    {   $array = [];
        return View::create($array, Response::HTTP_OK);
    }


     public function trimArrayValues($arrayContent)
    {
        // checking first if $arrayContent passed is empty
        // then returning the input parameter content.
        if (empty($arrayContent)) {
            return $arrayContent;
        }
        // Iterating through array Content and trimming values.
        foreach ($arrayContent as $key => $value) {
            if (is_array($value)) {
                // Increasing recursion count
                $this->recursiveCount++;
                // For Stopping recursive call to go beyond limit.
                if ($this->recursiveCount > 2000) {
                    break;
                }
                // recursive call to function for trimming Array content values.
                $arrayContent[trim($key)] = (!empty($value))
                    ? $this->trimArrayValues($value)
                    : $value
                ;

                // Removing non-trimmed Keys.
                if ((string)trim($key) !== (string)$key) {
                    unset($arrayContent[$key]);
                }
            } elseif (!is_array($value) && !is_object($value)) {
                $arrayContent[trim($key)] = is_string($value)
                    ? ((empty($value = trim($value)) && $value !== "0")
                        ? null
                        : htmlspecialchars($value, ENT_QUOTES, 'UTF-8')) // Handling Html input
                    : htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); // for XSS Prevention

                // Removing non-trimmed Keys From Array.
                if ((string)trim($key) !== (string)$key) {
                    unset($arrayContent[$key]);
                }
            }
        }

        return $arrayContent;
    }


}