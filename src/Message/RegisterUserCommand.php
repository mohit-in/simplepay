<?php

namespace App\Message;
use Symfony\Component\Validator\Constraints as Assert;

final class RegisterUserCommand
{
    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
     private $name;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Email()
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private $mobile;

    /**
     * @Assert\NotBlank(message="Please enter a clever nickname")
     * @Assert\Length(min=6)
     */
    private $password;

    /**
     * CreateUserMessage constructor.
     * @param $name
     * @param $email
     * @param $mobile
     * @param $password
     */
    public function __construct($name, $email, $mobile, $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->mobile = $mobile;
        $this->password = $password;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param mixed $mobile
     */
    public function setMobile($mobile): void
    {
        $this->mobile = $mobile;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }
}
