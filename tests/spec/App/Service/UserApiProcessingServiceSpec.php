<?php

namespace spec\App\Service;

use App\Entity\User;
use App\Service\UserApiProcessingService;
use PhpSpec\ObjectBehavior;

class UserApiProcessingServiceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserApiProcessingService::class);
    }
    function it_process_user_create_request()
    {
        $user = new User();

        $requestContent['name']="mohit";
        $requestContent['email']="mohit@gmail.com";
        $requestContent['mobile']=9999345816;
        $requestContent['status']=1234;
        $requestContent['password']=1234;

        $this->processCreateUserRequest($requestContent)->shouldReturn($user);

    }
}
