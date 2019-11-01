<?php

namespace spec\App\Handler;

use App\Command\RegisterUserCommand;
use App\Command\UpdateUserCommand;
use App\Entity\User;
use App\Handler\SaveUserHandler;
use App\Repository\DoctrineUnitOfWorkRepository;
use App\Repository\UserRepository;
use PhpSpec\ObjectBehavior;
use PhpSpec\Wrapper\Collaborator;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class SaveUserHandlerSpec
 * @package spec\App\MessageHandler
 */
class SaveUserHandlerSpec extends ObjectBehavior
{
    /**
     * Funtion to check initialising behavior of handler class
     */
    function it_is_initializable()
    {
        $this->shouldHaveType(SaveUserHandler::class);
    }

    /**
     * Function to initialise dependencies for specs.
     *
     * @param UserRepository|Collaborator $userRepository
     * @param DoctrineUnitOfWorkRepository|Collaborator $unitOfWork
     */
    function let(
        UserRepository $userRepository,
        DoctrineUnitOfWorkRepository $unitOfWork
    )
    {
        $this->beConstructedWith($userRepository, $unitOfWork);
    }

    /**
     * Function to check success behavior of register user command.
     *
     * @param UserRepository|Collaborator $userRepository
     * @param RegisterUserCommand $command
     * @param User|Collaborator $user
     * @param DoctrineUnitOfWorkRepository|Collaborator $unitOfWork
     */
    function it_check_success_behavior_of_register_user_command(
        UserRepository $userRepository,
        RegisterUserCommand $command,
        User $user,
        DoctrineUnitOfWorkRepository $unitOfWork
    )
    {
        $command->getId()->shouldBeCalled()->willReturn();
        $command->getEmail()->willReturn("mohit@gmail.com");

        $userRepository->findOneByEmail("mohit@gmail.com")->shouldBeCalled()->willReturn();

        $command->getUser()->shouldBeCalled()->willReturn($user);

        $unitOfWork->save($user)->shouldBeCalled();
        $unitOfWork->commit()->shouldBeCalled();

        $this->__invoke($command);

    }

    /**
     * Function to check throw exception behavior of register user command
     * in case of user already present in system by same email.
     *
     * @param UserRepository|Collaborator $userRepository
     * @param RegisterUserCommand|Collaborator $command
     * @param User|Collaborator $user
     */
    function it_check_throw_exception_behavior_of_register_user_command(
        UserRepository $userRepository,
        RegisterUserCommand $command,
        User $user
    )
    {

        $command->getId()->shouldBeCalled()->willReturn();
        $command->getEmail()->willReturn("mohit@gmail.com");

        $userRepository->findOneByEmail("mohit@gmail.com")->shouldBeCalled()->willReturn($user);

        $this->shouldThrow(ConflictHttpException::class)->during__invoke($command);
    }

    /**
     * Function to check success behavior of update user command.
     *
     * @param UserRepository|Collaborator $userRepository
     * @param SaveUserCommand|Collaborator $command
     * @param User|Collaborator $user
     * @param DoctrineUnitOfWorkRepository|Collaborator $unitOfWork
     */
    function it_check_success_behavior_of_update_user_command(
        UserRepository $userRepository,
        UpdateUserCommand $command,
        User $user,
        DoctrineUnitOfWorkRepository $unitOfWork
    )
    {
        $command->getId()->shouldBeCalled()->willReturn(1);
        $command->getEmail()->willReturn("mohit@gmail.com");

        $userRepository->find(1)->shouldBeCalled()->willReturn($user);

        $command->getName()->shouldBeCalled()->willReturn("mohit");
        $user->setName("mohit")->shouldBeCalled();
        $command->getEmail()->shouldBeCalled()->willReturn("mohit@gmail.com");
        $user->setEmail("mohit@gmail.com")->shouldBeCalled();
        $command->getMobile()->shouldBeCalled()->willReturn("9999345816");
        $user->setMobile("9999345816")->shouldBeCalled();
        $command->getPassword()->shouldBeCalled()->willReturn("123456");
        $user->setPassword("123456")->shouldBeCalled();

        $unitOfWork->save($user)->shouldBeCalled();
        $unitOfWork->commit()->shouldBeCalled();

        $this->__invoke($command);

    }

    /**
     * Function to check throw exception behavior of update user command
     * in case of user not found in system by id.
     *
     * @param UserRepository|Collaborator $userRepository
     * @param UpdateUserCommand|Collaborator $command
     */
    function it_check_throw_exception_behavior_of_update_user_command(
        UserRepository $userRepository,
        UpdateUserCommand $command
    )
    {
        $command->getId()->shouldBeCalled()->willReturn(1);

        $userRepository->find(1)->shouldBeCalled()->willReturn();

        $this->shouldThrow(NotFoundHttpException::class)->during__invoke($command);
    }


}
