<?php

namespace App\Controller\API\V1\User;

use App\Message\RegisterUserCommand;

use App\MessageHandler\RegisterUserHandler;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class UserControllerTemp extends FOSRestController
{
    /**
     * Function to handle User Create API request
     * @Rest\Post("/")
     * @param Request $request
     * @param MessageBusInterface $messageBus
     * @return View
     */
    public function RegisterUser(Request $request,MessageBusInterface $messageBus)
    {
        $requestContent = $request->request->All();
        $name = $requestContent['name']??'';
        $email = $requestContent['email']??null;
        $mobile = $requestContent['mobile']??null;
        $password = $requestContent['password']??null;

        $envelope = $messageBus->dispatch(new RegisterUserCommand($name,$email,$mobile,$password));
        $handled = $envelope->last(HandledStamp::class);
        $response = $handled->getResult();

        return View::create($response, Response::HTTP_CREATED);
    }

    /**
     * Function to GET the details of user by using user id.
     * @Rest\Get("/{id}")
     * @param Request $request
     * @param $id
     * @return View
     */
    public function getUserDetails(Request $request, $id)
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
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteUser(Request $request, $id)
    {
        $requestContent = array();
        $requestContent['id'] = $id;

        $response = $this->container
            ->get('user_api_processing_service')
            ->processDeleteUserRequest($requestContent);
        return View::create($response, Response::HTTP_NO_CONTENT);
    }

    /**
     * Function to handle User Update API request
     * @Rest\Patch("/{id}")
     * @param Request $request
     * @param $id
     * @return View
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function UpdateUserDetails(Request $request, $id)
    {

        $requestContent = $request->request->all();
        $requestContent['id'] = $id;

        $response = $this->container
            ->get('user_api_processing_service')
            ->processUpdateUserRequest($requestContent);
        return View::create($response, Response::HTTP_NO_CONTENT);
    }
}