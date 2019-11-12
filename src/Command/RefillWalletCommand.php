<?php


namespace App\Command;

use JMS\Serializer\Annotation as Serializer;

use JMS\Serializer\scalar;
use JMS\Serializer\SerializerBuilder;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Transaction;

/**
 * Class RefillWalletCommand
 * @package App\Command
 */
class RefillWalletCommand
{
    /**
     * @var int $userId
     * @Assert\NotNull(message= "User must not be empty")
     * @Serializer\Type("int")
     */
    private $userId;

    /**
     * @var float $amount
     * @Assert\GreaterThan(value="0",message="Amount must be greater than 0")
     * @Serializer\Type("float")
     */
    private $amount;

    private $transaction;

    /**
     * RefillWalletCommand constructor.
     * @param $userId
     * @param $parameters
     * @throws \Exception
     */
    public function __construct($userId, $parameters)
    {
        $this->userId = $userId;
        $this->amount = $parameters['amount']??0;

        $serializer = SerializerBuilder::create()->build();
        $transaction = $serializer->deserialize(json_encode($parameters), Transaction::class, 'json');
        $transaction->setSenderId('11');
        $transaction->setType(1);
        $transaction->setUuid(Uuid::uuid1());
        $this->transaction = $transaction;
    }

    /**
     * @return array|scalar|mixed|object
     */
    public function getTransaction()
    {
        return $this->transaction;
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