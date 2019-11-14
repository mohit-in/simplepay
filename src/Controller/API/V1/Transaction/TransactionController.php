<?php

namespace App\Controller\API\V1\Transaction;

use App\Command\MoneyTransferCommand;
use App\Command\WalletRefillCommand;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Messenger\MessageBusInterface;


/**
 * Class TransactionController
 */
class TransactionController extends AbstractFOSRestController
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * TransactionController constructor.
     * @param MessageBusInterface $messageBus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * Function to handle refill wallet request
     *
     * @Rest\Post("/wallet-refill/{userId}", requirements={"id"="^[1-9][0-9]*"})
     *
     * @param Request $request
     * @param int $userId
     *
     * @return View
     *
     * @throws \Exception
     */
    public function WalletRefill(Request $request, int $userId): View
    {
        try {
            $this->messageBus->dispatch(new WalletRefillCommand($userId, $request->request->all()));
        } catch (ValidationFailedException $exception) {
            throw new BadRequestHttpException($exception->getViolations()->get(0)->getMessage());
        }

        return View::create(null, Response::HTTP_CREATED);
    }


    /**
     * Function to handle refill wallet request
     *
     * @Rest\Post("/transfer-money/{userId}", requirements={"id"="^[1-9][0-9]*"})
     *
     * @param Request $request
     * @param int $userId
     *
     * @return View
     *
     * @throws \Exception
     */
    public function moneyTransfer(Request $request, int $userId): View
    {
        try {
            $this->messageBus->dispatch(new MoneyTransferCommand($userId, $request->request->all()));
        } catch (ValidationFailedException $exception) {
            throw new BadRequestHttpException($exception->getViolations()->get(0)->getMessage());
        }

        return View::create(null, Response::HTTP_CREATED);
    }

    /**
     * Function to handle refill wallet request
     *
     * @Rest\Get("/transaction/list")
     *
     * @param Request $request
     * @return void
     *
     */
    public function getTransactionList(Request $request): void
    {
        print_r($request->query->all());exit;
    }
}
