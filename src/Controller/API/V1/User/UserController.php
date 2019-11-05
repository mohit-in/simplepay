<?php

namespace App\Controller\API\V1\User;

use App\Command\RegisterUserCommand;
use App\Command\UpdateUserCommand;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;


/**
 * Class UserController
 * @package App\Controller\API\V1\User
 */
class UserController extends AbstractFOSRestController
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * UserController constructor.
     *
     * @param MessageBusInterface $messageBus
     * @param UserRepository $userRepository
     * @param UserService $userService
     * @param LoggerInterface $logger
     */
    public function __construct(
        MessageBusInterface $messageBus,
        UserRepository $userRepository,
        UserService $userService,
        LoggerInterface $logger
    )
    {
        $this->messageBus     = $messageBus;
        $this->userRepository = $userRepository;
        $this->userService    = $userService;
        $this->logger         = $logger;
    }

    /**
     * Function to handle User Create API request
     * @Rest\Post("/user")
     * @param Request $request
     * @return View
     * @throws ORMException
     */
    public function registerUser(Request $request): View
    {
        try {
            $user = new User();
            $envelope = $this->messageBus->dispatch(new RegisterUserCommand($user, $request->request->all()));
            /** @var User $user */
            $user = $envelope->last(HandledStamp::class)->getResult();
            $this->userRepository->commit();
        } catch (ValidationFailedException $exception) {
            throw new BadRequestHttpException($exception->getViolations()->get(0)->getMessage());
        }

        return View::create($user, Response::HTTP_CREATED);
    }

    /**
     * Function to handle User Update API request
     * @Rest\Patch("/user/{id}")
     * @param Request $request
     * @param $id
     *
     * @return View
     * @throws ORMException
     */
    public function updateUserDetails(Request $request, $id)
    {
        try {
            $envelope = $this->messageBus->dispatch(new UpdateUserCommand($id, $request->request->all()));
            $envelope->last(HandledStamp::class)->getResult();
            $this->userRepository->commit();
        } catch (ValidationFailedException $exception) {
            print_r("dddddddddddddddddddddddddd");exit;
            throw new BadRequestHttpException($exception->getViolations()->get(0)->getMessage());
        }

        return View::create(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Function to GET the details of user by using user id.
     * @Rest\Get("/user/{id}")
     * @param Request $request
     * @param $id
     * @return View
     */
    public function getUserDetails(Request $request, $id)
    {
        return View::create($this->userService->findUserById($id), Response::HTTP_OK);
    }

    /**
     * Function to handle User Delete API request
     * @Rest\Delete("/user/{id}")
     * @param Request $request
     * @param $id
     *
     * @return View
     * @throws ORMException
     */
    public function deleteUser(Request $request, $id)
    {
        $this->userService->deleteUser($id);
        $this->userRepository->commit(); // Explicit Flush by the end of Operation.

        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}
