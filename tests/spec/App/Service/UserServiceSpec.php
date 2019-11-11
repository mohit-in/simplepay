<?php

namespace spec\App\Service;

use App\Entity\User;
use App\Repository\DoctrineUnitOfWorkRepository;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\ORMException;
use PhpSpec\ObjectBehavior;
use PhpSpec\Wrapper\Collaborator;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UserApiProcessingServiceSpec
 * @package spec\App\Service
 */
class UserServiceSpec extends ObjectBehavior
{
    /**
     * function to check class initializable behavior
     */
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(UserService::class);
    }

    /**
     * funtion to add dependencies for specs
     *
     * @param UserRepository|Collaborator $userRepository
     * @param ContainerInterface $container
     */
    public function let(UserRepository $userRepository, ContainerInterface $container): void
    {
        $this->beConstructedWith($userRepository, $container);
    }

    /**
     * funtion to process get user details request
     *
     * @param UserRepository|Collaborator $userRepository
     * @param User|Collaborator $user
     */
    public function it_should_return_a_user_if_a_user_found_in_system(UserRepository $userRepository, User $user): void
    {
        $userRepository->find(Argument::any())->shouldBeCalled()->willReturn($user);
        $this->findUserById(1)->shouldReturn($user);
    }

    /**
     * funtion to throw exception when user not found in system in process user details request
     *
     * @param UserRepository|Collaborator $userRepository
     * @param User|Collaborator $user
     */
    public function it_should_throw_an_exception_if_no_user_found_in_system(UserRepository $userRepository, User $user): void
    {
        $userRepository->find(1)->shouldBeCalled()->willReturn(null);
        $this->shouldThrow(NotFoundHttpException::class)->during(
            'findUserById',[1]);
    }

    /**
     * funtion to process delete user request
     *
     * @param UserRepository|Collaborator $userRepository
     * @param User|Collaborator $user
     * @throws ORMException
     */
    public function it_should_remove_a_user_if_a_user_found_in_system(UserRepository $userRepository, User $user): void
    {
        $userRepository->find(1)->shouldBeCalled()->willReturn($user);
        $userRepository->remove($user)->shouldBeCalled();

        $this->deleteUser(1);
    }

}
