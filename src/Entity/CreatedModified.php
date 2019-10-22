<?php

/**
 *  CreatedModified Entity for containing created_at and last_modified_at attributes
 *  which will be used in all the other entities.
 *
 *  @category Entity
 *  @author Mohit Sharma<mohit.sharma@mindfiresolutions.com>
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
abstract class CreatedModified
{
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $last_modified_at;

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getLastModifiedAt(): ?\DateTimeInterface
    {
        return $this->last_modified_at;
    }

    public function setLastModifiedAt(\DateTimeInterface $last_modified_at): self
    {
        $this->last_modified_at = $last_modified_at;

        return $this;
    }
}
