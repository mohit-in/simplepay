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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt()
    {
        $this->created_at = new \DateTime;

        return $this;
    }

    public function getLastModifiedAt(): ?\DateTimeInterface
    {
        return $this->last_modified_at;
    }

    public function setLastModifiedAt($last_modified_at)
    {
        $this->last_modified_at = new \DateTime;

        return $this;
    }
}