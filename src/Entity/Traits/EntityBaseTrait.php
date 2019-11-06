<?php


namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;


/**
 * Trait EntityBaseTrait
 * @package App\Entity\Traits
 *
 */
trait EntityBaseTrait
{
    /**
     * The unique auto incremented primary key.
     *
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned": true})
     *
     * @ORM\GeneratedValue
     *
     * @Serializer\Type("int")
     */
    protected $id;


    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="last_modified_at", type="datetime", nullable=true)
     *
     */
    protected $lastModifiedAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getLastModifiedAt(): DateTime
    {
        return $this->lastModifiedAt;
    }

    /**
     * @param DateTime $lastModifiedAt
     */
    public function setLastModifiedAt(DateTime $lastModifiedAt): void
    {
        $this->lastModifiedAt = $lastModifiedAt;
    }

    /**
     * Auto set the last_modified_at value.
     *
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->setLastModifiedAt(new DateTime());
    }

    /**
     * Set initial value for created_at/last_modified_at values.
     *
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $now = new DateTime();
        $this->setCreatedAt($now);
        $this->setLastModifiedAt($now);
    }


}