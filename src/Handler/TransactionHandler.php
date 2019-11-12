<?php


namespace App\Handler;

use App\Command\MoneyTransferCommand;
use App\Command\WalletRefillCommand;
use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\ORMException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

/**
 * Class TransactionHandler
 */
class TransactionHandler implements MessageSubscriberInterface
{
    /**
     * @var TransactionRepository
     */
    private $transactionRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * TransactionHandler constructor.
     * @param TransactionRepository $transactionRepository
     * @param UserService $userService
     * @param UserRepository $userRepository
     */
    public function __construct(TransactionRepository $transactionRepository, UserService $userService, UserRepository $userRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * Function to resolve method name.
     *
     * @return iterable
     */
    public static function getHandledMessages(): iterable
    {
        yield WalletRefillCommand::class => ['method' => '__invoke'];
        yield MoneyTransferCommand::class => ['method' => 'transferMoney'];
    }

    /**
     * Funtion to handle wallet refill command.
     *
     * @param WalletRefillCommand $command
     *
     * @throws ORMException
     */
    public function __invoke($command)
    {
        /* checking user by id*/
        $user = $this->userService->findUserById($command->getUserId());
        /* updating balance in user amount */
        $user->setBalance($user->getBalance() + $command->getAmount());
        $this->userRepository->save($user);

        $transaction = new Transaction();
        $transaction->setSenderId($command->getUserId());
        $transaction->setType(1);
        $transaction->setAmount($command->getAmount());
        $transaction->setUuid(Uuid::uuid1());

        /* saving wallet refill transaction */
        $this->transactionRepository->save($transaction);
    }

    /**
     * Function to handle transfer money command.
     *
     * @param MoneyTransferCommand $command
     *
     * @throws ORMException
     * @throws \Exception
     */
    public function transferMoney($command): void
    {
        /* checking sender by id */
        $sender = $this->userService->findUserById($command->getUserId());
        /* checking receiver by id */
        $receiver = $this->userService->findUserById($command->getReceiverId());

        if ($command->getAmount() >= $sender->getBalance()) {
            throw new UnprocessableEntityHttpException(sprintf('Insufficient balance'));
        }

        /* subtracting balance from sender amount */
        $sender->setBalance($sender->getBalance() - $command->getAmount());
        $this->userRepository->save($sender);

        /* adding balance in receiver amount */
        $receiver->setBalance($receiver->getBalance() + $command->getAmount());
        $this->userRepository->save($receiver);

        $transaction = new Transaction();
        $transaction->setSenderId($command->getUserId());
        $transaction->setReceiverId($command->getReceiverId());
        $transaction->setType(2);
        $transaction->setAmount($command->getAmount());
        $transaction->setUuid(Uuid::uuid1());
        /* saving money transfer transaction */
        $this->transactionRepository->save($transaction);
    }
}