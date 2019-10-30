<?php

namespace App\Controller\API\V1\User;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

use FOS\RestBundle\View\View;

use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use App\Message\SaveUserCommand;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class UserController
 * @package App\Controller\API\V1\User
 */
class UserController extends FOSRestController
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * UserController constructor.
     * @param MessageBusInterface $messageBus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }
    /**
     * Function to handle User Create API request
     * @Rest\Post("/")
     * @param Request $request
     * @return View
     */

    public function RegisterUser(Request $request)
    {
        $envelope = $this->messageBus->dispatch(new SaveUserCommand($request->request->all()));
        $handled = $envelope->last(HandledStamp::class);
        $response = $handled->getResult();
        return View::create($response, Response::HTTP_CREATED);
    }

    /**
     * Function to handle User Update API request
     * @Rest\Patch("/{id}")
     * @param Request $request
     * @param $id
     * @return View
     */
    public function UpdateUserDetails(Request $request, $id)
    {
        $requestContent = $request->request->all();
        $requestContent['id'] = $id;
        $envelope = $this->messageBus->dispatch(new SaveUserCommand($requestContent));
        $handled = $envelope->last(HandledStamp::class);
        $response = $handled->getResult();

        return View::create($response, Response::HTTP_NO_CONTENT);
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
        $requestContent['id'] = $id;
        $response = $this->container
            ->get('user_api_processing_service')
            ->processgetUserDetailsRequest($requestContent);
        #print_r($response);exit;
        return View::create($response, Response::HTTP_OK);
    }

    /**
     * Function to handle User Delete API request
     * @Rest\Delete("/{id}")
     * @param Request $request
     * @param $id
     * @return View
     */
    public function deleteUser(Request $request, $id)
    {
        $requestContent['id'] = $id;

        $response = $this->container
            ->get('user_api_processing_service')
            ->processDeleteUserRequest($requestContent);
        return View::create($response, Response::HTTP_NO_CONTENT);
    }
}
