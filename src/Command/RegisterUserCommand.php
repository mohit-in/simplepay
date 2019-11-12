<?php

namespace App\Command;

use App\Entity\User;
use Exception;
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
     * @var Uuid $uuid
     * @Assert\Type("Ramsey\Uuid\UuidInterface", message="Uuid should be of type uuid")
     * @Serializer\Type("uuid")
     */
    private $uuid;

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
     *
     * @Assert\NotNull(message="Password must not be empty")
     * @Assert\Length(min="6", minMessage="Password must be greater than or equal to six digit in length")
     *
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
     * @throws Exception
     */
    public function __construct(User $user,  array  $arguments = [])
    {
        $this->user = $user;
        $this->name = $arguments['name'];
        $this->email = $arguments['email'];
        $this->mobile = $arguments['mobile'];
        $this->password = $arguments['password'];
        $this->uuid = $arguments['uuid']??Uuid::uuid1();
    }

    /**
     * Get id
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }


    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile(): string
    {
        return $this->mobile;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword(): string
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
