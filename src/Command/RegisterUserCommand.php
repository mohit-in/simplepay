<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RegisterUser
 * @package App\Command
 */
class RegisterUserCommand
{
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
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
     * @var User
     */
    private $user;

    /**
     *  Constructor to set parameters of save user.
     *
     * @param User $user
     * @param array $arguments
     */
    public function __construct(User $user, array $arguments = array())
    {
        $this->user = $user;
        $this->user->setName($arguments["name"]);
        $this->user->setEmail($arguments["email"]);
        $this->user->setMobile($arguments["mobile"]);
        $this->user->setPassword($arguments["password"]);

        $this->name = $arguments["name"];
        $this->email = $arguments["email"];
        $this->password = $arguments["password"];
        $this->mobile = $arguments["mobile"];

    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

}
