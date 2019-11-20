<?php

namespace App\Controller\API\V1\Transaction;

use App\Command\MoneyTransferCommand;
use App\Command\WalletRefillCommand;
use App\Service\TransactionService;
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
     * @var TransactionService
     */
    private $transactionService;

    /**
     * TransactionController constructor.
     * @param MessageBusInterface $messageBus
     * @param TransactionService $transactionService
     */
    public function __construct(MessageBusInterface $messageBus, TransactionService $transactionService)
    {
        $this->messageBus = $messageBus;
        $this->transactionService = $transactionService;
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

        return View::create(null, Response::HTTP_NO_CONTENT);
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

        return View::create(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Function to handle get transaction listing request.
     *
     * @Rest\Get("/transaction/list")
     *
     * @param Request $request
     *
     * @return View
     */
    public function getTransactionList(Request $request): View
    {
        $parameters = $this->transactionService->validateParameters($request->query->all());
        return View::create($this->transactionService->findTransactionList($parameters), Response::HTTP_OK);
    }

    /**
     * Function to handle get transaction details request.
     *
     * @Rest\Get("/transaction/{id}", requirements={"id"="^[1-9][0-9]*"})
     *
     * @param Request $request
     *
     * @return View
     */
    public function getTransactionDetails(Request $request, int $id): View
    {
        return View::create($this->transactionService->findTransactionDetails($id), Response::HTTP_OK);
    }
}
