<?php

namespace App\Command;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UpdateUserCommand
 * @package App\Command
 */
class UpdateUserCommand
{
    /**
     * @var int $id
     *
     * @Assert\NotNull(message="Id must not be empty")
     *
     * @Serializer\Type("int")
     */
    private $id;

    /* Temporary variable */

    private $uuid;

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @var string $name
     *
     * @Assert\NotBlank(allowNull = true, message="Name must not be empty")
     *
     * @Serializer\Type("string")
     */
    private $name;

    /**
     * @var string $email
     *
     * @Assert\NotBlank(allowNull = true, message="Email must not be empty")
     *
     * @Serializer\Type("string")
     */
    private $email;

    /**
     * @var string $mobile
     *
     * @Assert\NotBlank(allowNull = true, message="Mobile must not be empty")
     *
     * @Serializer\Type("string")
     */
    private $mobile;

    /**
     * @var string $password
     *
     * @Assert\NotBlank(allowNull=true, message="Password must not be empty")
     *
     * @Serializer\Type("string")
     */
    private $password;

    /**
     * RegisterUserCommand constructor.
     * @param int $id
     * @param array $arguments
     */
    public function __construct(int $id, array $arguments = array())
    {
        $this->id = $id;
        $this->name = $arguments['name']??null;
        $this->email = $arguments['email']??null;
        $this->password = $arguments['password']??null;
        $this->mobile = $arguments['mobile']??null;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
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
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
