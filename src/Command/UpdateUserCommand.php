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

    public function __construct(int $id, array $parameters = array())
    {
        $this->id = $id;
        $this->name = $parameters["name"];
        if (!empty($parameters["mobile"])) {
            $this->mobile = $parameters["mobile"];
        }
        if (!empty($parameters["password"])) {
            $this->password = $parameters["password"];
        }
    }

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
}