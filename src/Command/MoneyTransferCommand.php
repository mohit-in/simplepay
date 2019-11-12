<?php


namespace App\Command;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class MoneyTransferCommand
{
    /**
     * @var int $userId
     *
     * @Assert\NotNull(message= "User Id must not be empty")
     *
     * @Serializer\Type("int")
     */
    private $userId;
    /**
     * @var int $receiverId
     *
     * @Assert\NotNull(message= "Receiver Id must not be empty")
     *
     * @Serializer\Type("int")
     */
    private $receiverId;
    /**
     * @var float $amount
     *
     * @Assert\GreaterThan(value="0", message="Amount must be greater than 0")
     *
     * @Serializer\Type("float")
     */
    private $amount;

    /**
     * RefillWalletCommand constructor.
     *
     * @param string $userId
     * @param array $parameters
     */
    public function __construct($userId, array $parameters = [])
    {
        $this->userId = $userId;
        $this->receiverId = $parameters['receiverId'] ?? null;
        $this->amount = $parameters['amount'] ?? 0;
    }

    /**
     * @return int
     */
    public function getReceiverId(): int
    {
        return $this->receiverId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }
}