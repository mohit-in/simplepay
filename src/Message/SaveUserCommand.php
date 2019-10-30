<?php

namespace App\Message;

use Symfony\Component\Validator\Constraints as Assert;

final class SaveUserCommand
{
    private $id;
    /**
     * @Assert\NotNull(message="Id must not be empty")
     */

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
     * @Assert\NotNull(message="Status must not be empty")
     */
    private $status;

    /**
     *  Constructor to set parameters of save user.
     *
     * @param $requestParameter
     */
    public function __construct($requestParameter)
    {

        if (!empty($requestParameter['id'])) {

            $this->id = $requestParameter['id'];
        }
        if (!empty($requestParameter['name'])) {

            $this->name = $requestParameter['name'];
        }
        if (!empty($requestParameter['email'])) {

            $this->email = $requestParameter['email'];
        }
        if (!empty($requestParameter['password'])) {

            $this->password = $requestParameter['password'];
        }
        if (!empty($requestParameter['mobile'])) {

            $this->mobile = $requestParameter['mobile'];
        }
        if (!empty($requestParameter['status'])) {

            $this->mobile = $requestParameter['status'];
        }
    }

    /**
     * @return mixed
     */
    public function getId()
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
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

}
