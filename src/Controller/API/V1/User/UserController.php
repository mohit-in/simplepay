<?php

namespace App\Controller\API\V1\User;

use App\Command\LoginUserCommand;
use App\Command\RegisterUserCommand;
use App\Command\UpdateUserCommand;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\ORMException;
use Exception;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
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
     * Function to handle User Create API request.
     *
     * @Rest\Post("/user", name="register_user")
     *
     * @param Request $request
     * @return View
     *
     * @throws Exception
     */
    public function registerUser(Request $request): View
    {
        try {
            $user = new User();
            $this->messageBus->dispatch(new RegisterUserCommand($user, $request->request->all()));
            /** @var User $user */
            #$user = $envelope->last(HandledStamp::class)->getResult();
        } catch (ValidationFailedException $exception) {
            throw new BadRequestHttpException($exception->getViolations()->get(0)->getMessage());
        }

        return View::create('', Response::HTTP_NO_CONTENT);
    }

    /**
     * Function to handle User Update API request
     * @Rest\Patch("/user/{id}", requirements={"id"="^[1-9][0-9]*"})
     * @param Request $request
     * @param int $id
     *
     *
     * @return View
     */
    public function updateUserDetails(Request $request, int $id): View
    {
        try {
            $envelope = $this->messageBus->dispatch(new UpdateUserCommand($id, $request->request->all()));
            $envelope->last(HandledStamp::class)->getResult();
        } catch (ValidationFailedException $exception) {
            throw new BadRequestHttpException($exception->getViolations()->get(0)->getMessage());
        }

        return View::create(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Function to GET the details of user by using user id.
     * @Rest\Get("/user/{id}", requirements={"id"="^[1-9][0-9]*"})
     * @param Request $request
     * @param int $id
     * @return View
     */
    public function getUserDetails(Request $request, int $id): View
    {
        return View::create($this->userService->findUserById($id), Response::HTTP_OK);
    }

    /**
     * Function to handle User Delete API request
     * @Rest\Delete("/user/{id}", requirements={"id"="^[1-9][0-9]*"})
     * @param Request $request
     * @param int $id
     *
     * @return View
     * @throws ORMException
     */
    public function deleteUser(Request $request, int $id): View
    {
        $this->userService->deleteUser($id);
        $this->userRepository->commit(); // Explicit Flush by the end of Operation.

        return View::create(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Function to handle login user request.
     *
     * @Rest\Post("user/login" , name="login_user")
     *
     * @param Request $request
     *
     * @return View
     *
     */
    public function generateToken(Request $request): View
    {
        try {
            $envelope = $this->messageBus->dispatch( //call token generation command
                new LoginUserCommand(
                    $request->request->all()
                )
            );
            $result['token'] = $envelope->last(HandledStamp::class)->getResult(); // return token
        } catch (ValidationFailedException $exception) {
            throw new BadRequestHttpException($exception->getViolations()->get(0)->getMessage());
        }

        return View::create($result, Response::HTTP_CREATED);
    }
}
