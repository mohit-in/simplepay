<?php


namespace App\Handler;


use App\Command\RefillWalletCommand;
use App\Command\RegisterUserCommand;
use App\Command\UpdateUserCommand;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use App\Service\UserService;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class TransactionHandler implements  MessageSubscriberInterface
{
    private  $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public static function getHandledMessages(): iterable
    {
        yield RefillWalletCommand::class => ['method' => '__invoke'];
        #yield RegisterUserCommand::class => ['method' => '__invoke'];
    }
    public function __invoke($command)
    {
        $this->transactionRepository->save($command->getTransaction());
    }

}