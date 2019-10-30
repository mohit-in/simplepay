<?php

namespace spec\App\Service;

use App\Entity\User;
use App\Repository\DoctrineUnitOfWorkRepository;
use App\Repository\UserRepository;
use App\Service\UserApiProcessingService;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class UserApiProcessingServiceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserApiProcessingService::class);
    }
    function let(UserRepository $userRepository, DoctrineUnitOfWorkRepository $unitOfWork){
        $this->beConstructedWith($userRepository, $unitOfWork);

    }
    function it_process_get_user_details_request(UserRepository $userRepository, User $user)
    {
        $userRepository->find(1)->shouldBeCalled()->willReturn($user);
        $this->processGetUserDetailsRequest(['id' => 1])->shouldReturn($user);
    }
    function it_process_delete_user_request(UserRepository $userRepository,User $user)
    {
        $userRepository->find(1)->shouldBeCalled()->willReturn($user);
        $this->processGetUserDetailsRequest(['id' => 1])->shouldReturn($user);
    }
}
