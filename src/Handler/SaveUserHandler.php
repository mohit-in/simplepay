<?php


namespace App\Handler;

use App\Command\RegisterUserCommand;
use App\Command\SaveUserCommand;
use App\Command\UpdateUserCommand;
use App\Entity\User;

use App\Repository\DoctrineUnitOfWorkRepository;
use App\Repository\UserRepository;
use App\Service\UserService;
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
     * @var UserService
     */
    private $userService;

    /**
     * @var User
     */
    private $user;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param UserService $userService
     */
    public function __construct(UserRepository $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService    = $userService;
    }

    public static function getHandledMessages(): iterable
    {
        yield UpdateUserCommand::class => ['method' => '__invoke'];
        yield RegisterUserCommand::class => ['method' => '__invoke'];
    }

    public function __invoke($command)
    {
        if (!empty($command->getId())) {
            $this->user = $this->userService->findUserById($command->getId());

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
                throw new ConflictHttpException("User exists with Email: ". $command->getEmail());
            }

            $this->user = $command->getUser();
        }

        $this->userRepository->save($this->user);

        return $this->user;
    }


}
