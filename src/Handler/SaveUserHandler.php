<?php


namespace App\Handler;

use App\Command\RegisterUserCommand;
use App\Command\SaveUserCommand;
use App\Command\UpdateUserCommand;
use App\Entity\User;

use App\Repository\DoctrineUnitOfWorkRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

    private $user;

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
        if (!empty($command->getId())) {
            $this->user = $this->userRepository->find($command->getId());
            if (empty($this->user)) {
                throw new NotFoundHttpException("user not found by id: ". $command->getId());
            }
            if (!empty($command->getName())) {
                $this->user->setName($command->getName());
            }
            if (!empty($command->getEmail())) {
                $this->user->setEmail($command->getEmail());
            }
            if (!empty($command->getMobile())) {
                $this->user->setMobile($command->getMobile());
            }
            if(!empty($command->getPassword())) {
                $this->user->setPassword($command->getPassword());
            }
        }
        else {
            if (!empty($this->userRepository->findOneByEmail($command->getEmail()))) {
                throw new ConflictHttpException("user found by email: ". $command->getEmail());
            }
            $this->user = $command->getUser();

        }
        $this->unitOfWork->save($this->user);
        $this->unitOfWork->commit();

        return $this->user;
    }


}