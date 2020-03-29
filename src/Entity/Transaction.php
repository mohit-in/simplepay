<?php

namespace App\Entity;

use App\Entity\Traits\EntityBaseTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 * @ORM\HasLifecycleCallbacks
 *
 * @Serializer\AccessorOrder("custom", custom = {"id", "uuid", "senderId", "receiverId", "amount", "status"})
 */
class Transaction
{
    use EntityBaseTrait;

    public const WalletRefill = 1;
    public const WalletTransfer = 2;
    public const Success = 1;
    public const Pending = 0;
    public const Failed = -1;

    /**
     * @var Uuid $uuid
     *
     * @ORM\Column(type="uuid", length=255)
     *
     * @Serializer\Type("string")
     */
    private $uuid;

    /**
     * @var integer $sender
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="sender_id", referencedColumnName="id", onDelete="CASCADE")
     * @ORM\Column(type="integer", length=255)
     *
     * @Serializer\Type("int")
     */
    private $senderId;

    /**
     * @var integer $receiver
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="receiver_id", referencedColumnName="id", onDelete="CASCADE")
     * @ORM\Column(type="integer", nullable=true, length=255)
     *
     * @Serializer\Type("int")
     */

    private $receiverId;

    /**
     * @var integer $type
     *
     * @ORM\Column(type="integer", length=255)
     * @Serializer\Type("string")
     */
    private $type;

    /**
     * @var float $amount
     *
     * @ORM\Column(type="float", length=255)
     * @Assert\GreaterThan(0, message="Amount must not be greater than zero")
     *
     * @Serializer\Type("float")
     */
    private $amount;

    /**
     * @var $status
     *
     * @ORM\Column(type="integer", length=10,  options={"default" : "1"})
     *
     * @Assert\Choice({"1", "0", "-1"})
     *
     * @Serializer\Type("int")
     */
    private $status = self::Success;

    /**
     * @return Uuid
     */
    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    /**
     * @param Uuid $uuid
     */
    public function setUuid(Uuid $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return int
     */
    public function getSenderId(): int
    {
        return $this->senderId;
    }

    /**
     * @param int $senderId
     */
    public function setSenderId(int $senderId): void
    {
        $this->senderId = $senderId;
    }

    /**
     * @return int
     */
    public function getReceiverId(): int
    {
        return $this->receiverId;
    }

    /**
     * @param int $receiverId
     */
    public function setReceiverId(int $receiverId): void
    {
        $this->receiverId = $receiverId;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return self::$this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }
}
