<?php


namespace App\Command;

use Symfony\Component\Validator\Constraints as Assert;


class UpdateUserCommand
{
    /**
     * @Assert\NotNull(message="Name must not be empty")
     */
    private $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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

    /**
     *
     */
    private $name;

    /**
     *
     */
    private $email;

    /**
     *
     */
    private $mobile;

    /**
     *
     */
    private $password;

    public function __construct(int $id,  array $parameters = array())
    {
        $this->id = $id;
        $this->name = $parameters["name"];
        $this->mobile = $parameters["mobile"];
        $this->password = $parameters["password"];
    }
}