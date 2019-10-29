<?php


namespace App\Message;

use Symfony\Component\Validator\Constraints as Assert;

final class GetUserDetailsCommand
{
    /**
     * @Assert\Positive(message="Id should be positive integer")
     */
    private $id;

    /**
     * GetUserDetailsCommand constructor.
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