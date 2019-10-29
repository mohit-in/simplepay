<?php


namespace App\Message;


use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class RemoveUserCommand
 * @package App\Message
 */
class DeleteUserAccountCommand
{
    /**
     * @var $id
     *
     * @Assert\Positive(message="Id should be positive integer")
     */
    private $id;

    /**
     * RemoveUserCommand constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}