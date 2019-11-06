<?php

namespace App\Command;

use App\Entity\User;
use JMS\Serializer\Annotation as Serializer;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RegisterUser
 * @package App\Command
 */
class RegisterUserCommand
{
    /**
     * @var int $id
     * @Serializer\Exclude()
     */
    private $id;

    /**
     * @var string $name
     * @Assert\NotNull(message="Name must not be empty")
     * @Serializer\Type("string")
     */
    private $name;

    /**
     * @var string $email
     * @Assert\NotNull(message="Email must not be empty")
     * @Serializer\Type("string")
     */
    private $email;


    /**
     * @var string $name
     * @Assert\NotNull(message="Mobile must not be empty")
     * @Serializer\Type("string")
     */
    private $mobile;

    /**
     * @var string $mobile
     * @Assert\NotNull(message="Password must not be empty")
     * @Serializer\Type("string")
     */
    private $password;

    /**
     * @var User $user
     * @Assert\NotBlank(message="User is required")
     */
    private $user;

    /**
     * RegisterUserCommand constructor.
     * @param User $user
     * @param array $arguments
     * @throws \Exception
     */
    public function __construct(User $user, array $arguments = array())
    {
        $this->user = $user;
        $this->user->setUuid(Uuid::uuid1());
        $this->user->setName($arguments["name"]);
        $this->user->setEmail($arguments["email"]);
        $this->user->setMobile($arguments["mobile"]);
        $this->user->setPassword($arguments["password"]);


        $this->name = $arguments["name"];
        $this->email = $arguments["email"];
        $this->mobile = $arguments["mobile"];
        $this->password = $arguments["password"];
    }

    /**
     * Get id
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
