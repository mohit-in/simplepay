<?php

namespace spec\App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserApiProcessingService;
use Doctrine\ORM\EntityManager;
use PhpSpec\ObjectBehavior;

class UserApiProcessingServiceSpec extends ObjectBehavior
{
    private $entityManager;

    function it_is_initializable()
    {
        $this->shouldHaveType(UserApiProcessingService::class);
    }
    function let(EntityManager $entityManager,UserRepository $userRepository){
        $this->beConstructedWith($entityManager,$userRepository);

    }
    function it_process_user_create_request(UserRepository $userRepository,EntityManager $entityManager)
    {
        $user = new User();

        $requestContent['name']="mohit";
        $requestContent['email']="mohit@gmail.com";
        $requestContent['mobile']=9999345816;
        $requestContent['password']=123456;

        $this->processCreateUserRequest($requestContent,$userRepository)->shouldReturn($user);

    }
}
