<?php

namespace spec\App\Service;

use App\Entity\User;
use App\Repository\DoctrineUnitOfWorkRepository;
use App\Repository\UserRepository;
use App\Service\UserApiProcessingService;
use PhpSpec\ObjectBehavior;
use PhpSpec\Wrapper\Collaborator;
use Prophecy\Argument;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class UserApiProcessingServiceSpec
 * @package spec\App\Service
 */
class UserApiProcessingServiceSpec extends ObjectBehavior
{
    /**
     * function to check class initializable behavior
     */
    function it_is_initializable()
    {
        $this->shouldHaveType(UserApiProcessingService::class);
    }

    /**
     * funtion to add dependencies for specs
     *
     * @param UserRepository|Collaborator $userRepository
     * @param DoctrineUnitOfWorkRepository|Collaborator $unitOfWork
     */
    function let(UserRepository $userRepository, DoctrineUnitOfWorkRepository $unitOfWork)
    {
        $this->beConstructedWith($userRepository, $unitOfWork);

    }

    /**
     * funtion to process get user details request
     *
     * @param UserRepository|Collaborator $userRepository
     * @param User|Collaborator $user
     */
    function it_process_get_user_details_request(UserRepository $userRepository, User $user)
    {
        $userRepository->find(Argument::any())->shouldBeCalled()->willReturn($user);
        $this->processGetUserDetailsRequest(['id' => Argument::any()])->shouldReturn($user);
    }

    /**
     * funtion to throw exception when user not found in system in process user details request
     *
     * @param UserRepository|Collaborator $userRepository
     * @param User|Collaborator $user
     */
    function it_throw_exception_when_user_not_found_in_process_user_details_request(UserRepository $userRepository, User $user)
    {
        $userRepository->find(Argument::any())->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(HttpException::class)->during(
            'ProcessGetUserDetailsRequest',
            ['id' =>1]);
    }


    /**
     * * funtion to process delete user request
     *
     * @param UserRepository|Collaborator $userRepository
     * @param User|Collaborator $user
     * @param DoctrineUnitOfWorkRepository $unitOfWork
     */
    function it_process_delete_user_request(
        UserRepository $userRepository,
        User $user,
        DoctrineUnitOfWorkRepository $unitOfWork)
    {
        $userRepository->find(Argument::any())->shouldBeCalledOnce()->willReturn($user);
        $unitOfWork->remove($user)->shouldBeCalledOnce();
        $unitOfWork->commit()->shouldBeCalledOnce();
        $this->processDeleteUserRequest(['id' => Argument::any()])->shouldReturn($user);
    }

    function it_throw_exception_when_user_not_found_in_process_delete_user_request(
        UserRepository $userRepository)
    {
        $userRepository->find(Argument::any())->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(HttpException::class)->during(
            'ProcessDeleteUserRequest', ['id' => 1]);
    }


}
