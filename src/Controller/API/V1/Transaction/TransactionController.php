<?php

namespace App\Controller\API\V1\Transaction;

use App\Command\RefillWalletCommand;
use App\Command\UpdateUserCommand;
use App\Service\UserService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;


/**
 * Class TransactionController
 * @package App\Controller\API\V1\Transaction
 */
class TransactionController extends AbstractFOSRestController
{
    private  $userService;
    private $messageBus;

    /**
     * TransactionController constructor.
     * @param UserService $userService
     * @param MessageBusInterface $messageBus
     */
    public function __construct(UserService $userService, MessageBusInterface $messageBus)
    {
        $this->userService =$userService;
        $this->messageBus = $messageBus;
    }

    /**
     * Function to handle refill wallet request
     *
     * @Rest\Post("/wallet-refill/{userId}")
     * @param Request $request
     * @param $userId
     * @return View
     */
    public function refillWallet(Request $request, $userId)
    {
        $user = $this->userService->findUserById($userId);
        $envelope = $this->messageBus->dispatch(new RefillWalletCommand($userId, $request->request->all()));

        return View::create(null, Response::HTTP_CREATED);

    }
}
