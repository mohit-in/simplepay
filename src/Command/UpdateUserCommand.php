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
     * @Assert\NotNull(message="Id must not be empty")
     * @Serializer\Type("int")
     */
    private $id;


    /**
     * @var string $email
     * @Assert\Blank|(message="Email must not be empty")
     * @Serializer\Type("string")
     */
    private $email;

    /**
     * @var string $mobile
     * @Assert\NotNull(message="Mobile must not be empty")
     * @Serializer\Type("string")
     */
    private $mobile;

    /**
     * @var string $password
     * @Assert\NotNull(message="Password must not be empty")
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
        //$serializer = SerializerBuilder::create()->build();
        //$serializer->fromArray($arguments, self::class, null);
        #$this->name = $arguments["name"];

        $this->mobile = $arguments["mobile"];
        if($arguments["password"])
        $this->password = $arguments["password"];

        $this->id = $id;
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
