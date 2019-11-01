<?php


namespace App\Handler;

use App\Command\RegisterUserCommand;
use App\Command\SaveUserCommand;
use App\Command\UpdateUserCommand;
use App\Entity\User;

use App\Repository\DoctrineUnitOfWorkRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

/**
 * Class SaveUserHandler
 * @package App\MessageHandler
 */
class SaveUserHandler implements MessageSubscriberInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var DoctrineUnitOfWorkRepository
     */
    private $unitOfWork;

    /**
     * UserApiProcessingService constructor.
     * @param UserRepository $userRepository
     * @param DoctrineUnitOfWorkRepository $unitOfWork
     */
    public function __construct(UserRepository $userRepository,
                                DoctrineUnitOfWorkRepository $unitOfWork)
    {
        $this->userRepository = $userRepository;
        $this->unitOfWork = $unitOfWork;
    }

    public static function getHandledMessages(): iterable
    {
        yield UpdateUserCommand::class => ['method' => '__invoke'];
        yield RegisterUserCommand::class => ['method' => '__invoke'];
    }

    public function __invoke($command)
    {
            
    }


}