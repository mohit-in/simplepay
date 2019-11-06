<?php

namespace App\Entity;

use App\Entity\Traits\EntityBaseTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 *
 * @Serializer\AccessorOrder("custom", custom = {"id", "uuid", "name", "email", "mobile"})
 */
class User
{
    use EntityBaseTrait;

    const INACTIVE = 0;
    const ACTIVE = 1;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotNull(message="{{value}} must not be empty")
     *
     * @Serializer\Type("string")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Assert\Email()
     * @Assert\NotNull(message="{{value}} must not be empty")
     *
     * @Serializer\Type("string")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotNull(message="{{value}} must not be empty")
     *
     * @Serializer\Type("string")
     */
    private $mobile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Length(min="6", minMessage="Password should be greater than or equal to 6 digit in length")
     * @Assert\NotNull()
     *
     * @Serializer\Type("string")
     */
    private $password;

    /**
     * @ORM\Column(type="float", nullable=true, options={"default" : 0})
     *
     * @Serializer\Type("float")
     */
    private $balance;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=10,  options={"default" : "1"})
     *
     * @Assert\Choice({"1", "0"})
     */
    private $status = self::ACTIVE;

    /**
     * @var string
     *
     * @ORM\Column(type="uuid", unique=true)
     *
     * @Serializer\Type("string")
     */
    private $uuid;

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }


    /**
     * Get Name
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set Name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get Email
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set Email
     *
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get Mobile
     *
     * @return string|null
     */
    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    /**
     * Set Mobile
     *
     * @param string $mobile
     *
     * @return $this
     */
    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * Get Status
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param string|null $status
     *
     * @return $this
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get password
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set Password
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get Balance
     * @return float|null
     */
    public function getBalance(): ?float
    {
        return $this->balance;
    }

    /**
     * Set Balance
     * @param float|null $balance
     * @return $this
     */
    public function setBalance(?float $balance): self
    {
        $this->balance = $balance;

        return $this;
    }
}
