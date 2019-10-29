<?php


namespace App\Message;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UpdateUserDetails
 * @package App\Message
 */
class UpdateUserDetailsCommand
{
    /**
     * @var $id
     * @Assert\Positive("Id must be positive integer)
     */
    private $id;

    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $mobile;
    /**
     * @var
     */
    private $status;
    /**
     * @var
     */
    private $password;

    /**
     * UpdateUserDetailsCommand constructor.
     * @param $id
     * @param $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
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
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
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

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}