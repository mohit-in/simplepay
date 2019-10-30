<?php

namespace App\Message;
use Symfony\Component\Validator\Constraints as Assert;

final class RegisterUserCommand
{
    /**
     * @Assert\NotNull(message="Name must not be empty")
     */
     private $name;

    /**
     * @Assert\Email(message="Email must be valid")
     */
    private $email;

    /**
     * @Assert\NotNull(message="Mobile must not be empty")
     */
    private $mobile;

    /**
     * @Assert\Length(min=6,minMessage="Password must be greater than or equal to 6 digit in length")
     */
    private $password;

    /**
     * CreateUserMessage constructor.
     * $
     * @param $requestParameter
     */
    public function __construct($requestParameter)
    {
        if(!empty($requestParameter['name'])) {

            $this->name = $requestParameter['name'];
        }
        if(!empty($requestParameter['email'])) {

            $this->email = $requestParameter['email'];
        }
        if(!empty($requestParameter['password'])) {

            $this->password = $requestParameter['password'];
        }
        if(!empty($requestParameter['mobile'])){

            $this->password = $requestParameter['mobile'];
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getMobile(): string
    {
        return $this->mobile;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

}
