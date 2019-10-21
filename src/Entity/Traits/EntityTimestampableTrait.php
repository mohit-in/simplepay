<?php


namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait EntityTimestampableTrait
{
    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    protected $created_at;

    /**
     * @var \DateTime
     * @ORM\Column(name="last_modified_at", type="datetime", nullable=true)
     */
    protected $last_modified_at;

    /**
     * Auto set the last_modified_at value.
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->setLastModifiedAt(new \DateTime());
    }

    /**
     * Set initial value for created_at/last_modified_at values.
     *
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $now = new \DateTime();
        $this->setCreatedAt($now);
        $this->setLastModifiedAt($now);
    }



    /**
     * Get last_modified_at value
     *
     * @return \DateTime
     */
    public function getLastModifiedAt(): \DateTime
    {
        return $this->last_modified_at;
    }

    /**
     * Get created_at value
     *
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    /**
     * Set created_at value
     *
     * @param \DateTime $created_at
     * @return $this
     */
    public function setCreatedAt(\DateTime $created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Set last_modified_at value
     *
     * @param \DateTime $last_modified_at
     * @return $this
     */
    public function setLastModifiedAt(\DateTime $last_modified_at)
    {
        $this->last_modified_at = $last_modified_at;

        return $this;
    }




}