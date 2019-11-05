<?php


namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Ramsey\Uuid\Uuid;


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
     * @ORM\GeneratedValue
     * @Serializer\Type("string")
     */
    protected $id;

    /**
     * @var string
     *
     *
     * @ORM\Column(type="uuid", name="uuid", unique=true)
     * @Serializer\Type("string")
     */
    protected $uuid;

    /**
     * @var DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Serializer\Exclude()
     */
    protected $created_at;

    /**
     * @var DateTime
     * @ORM\Column(name="last_modified_at", type="datetime", nullable=true)
     * @Serializer\Exclude()
     */
    protected $last_modified_at;


    /**
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get uuid
     *
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
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
        $this->uuid = Uuid::uuid4();
    }


    /**
     * Get last_modified_at value
     *
     * @return DateTime
     */
    public function getLastModifiedAt(): DateTime
    {
        return $this->last_modified_at;
    }

    /**
     * Set last_modified_at value
     *
     * @param DateTime $last_modified_at
     * @return $this
     */
    public function setLastModifiedAt(DateTime $last_modified_at)
    {
        $this->last_modified_at = $last_modified_at;

        return $this;
    }

    /**
     * Get created_at value
     *
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    /**
     * Set created_at value
     *
     * @param DateTime $created_at
     * @return $this
     */
    public function setCreatedAt(DateTime $created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }


}