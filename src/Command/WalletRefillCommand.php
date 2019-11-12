<?php


namespace App\Command;
use App\Entity\Transaction;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class WalletRefillCommand
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
     * @var float $amount
     *
     * @Assert\GreaterThan(value="0", message="Amount must be greater than 0")
     *
     * @Serializer\Type("float")
     */
    private $amount;

    private $transaction;

    /**
     * RefillWalletCommand constructor.
     *
     * @param string $userId
     * @param array $parameters
     */
    public function __construct($userId, array $parameters = [])
    {
        $this->userId = $userId;
        $this->amount = $parameters['amount'] ?? 0;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }
}