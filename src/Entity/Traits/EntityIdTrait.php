<?php


namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;


trait EntityIdTrait
{
    /**
     * The unique auto incremented primary key.
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned": true})
     * @ORM\GeneratedValue
     */
    protected $id;

}