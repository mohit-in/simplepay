<?php


namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;


trait EntityTimestampableTrait
{
    /*
       * @ORM\Column(type="datetime")
       */
    protected $created_at;

    /*
     * @ORM\Column(type="datetime")
     */
    protected $last_modified_at;

    protected function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    protected function setCreatedAt()
    {
        $this->created_at = new \DateTime;

        return $this;
    }

    protected function getLastModifiedAt(): ?\DateTimeInterface
    {
        return $this->last_modified_at;
    }

    protected function setLastModifiedAt()
    {
        $this->last_modified_at = new \DateTime;

        return $this;
    }
}