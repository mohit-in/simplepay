<?php


namespace App\Tests\Scenario\Traits;


use App\Entity\User;
use Ramsey\Uuid\Uuid;

trait TransactionTrait
{
    /**
     * @BeforeScenario  @WalletRefill
     */
    public function deleteWalletRefillTransaction(): void
    {
        #dump("DELETE FROM transaction where sender_id = 1 and receiever_id is null and amount =100");exit;
        $this->entityManager->getConnection()->executeQuery("DELETE FROM transaction where sender_id = 1 and receiver_id is null and amount =100");
    }
    /**
     * @BeforeScenario  @MoneyTransfer
     */
    public function deleteMoneyTransferTransaction(): void
    {
        $this->entityManager->getConnection()->executeQuery("DELETE FROM transaction where sender_id = 1 and receiver_id = 2 and amount =100");
    }
    /**
     * @BeforeScenario  @MoneyTransfer
     */
    public function inserReceivertUserInTheDatabase()
    {
        $this->entityManager->getConnection()->executeQuery("DELETE FROM user where id = 2 or email = 'ashish@gmail.com'");
        $uuid = Uuid::uuid1();
        $roles = json_encode(array('ROLE_ADMIN'));
        $password = $this->passwordEncoder->encodePassword(new User(), 123456);
        $this->entityManager->getConnection()->executeQuery("INSERT INTO user (id, uuid, balance, name, email, mobile, password, roles) 
                            values (2, '$uuid', 1000, 'ashish', 'ashish@gmail.com', '9811002233', '$password','$roles')");
    }

}