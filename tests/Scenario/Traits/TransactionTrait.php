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
        $this->entityManager->getConnection()->executeQuery("DELETE FROM transaction where sender_id = 1 and receiver_id is null and amount =100");
    }

    /**
     * @BeforeScenario  @MoneyTransfer
     */
    public function inserReceivertUserInTheDatabase(): void
    {
        $this->entityManager->getConnection()->executeQuery("DELETE FROM transaction where sender_id = 1 and receiver_id = 2 and amount =100");
        $this->entityManager->getConnection()->executeQuery("DELETE FROM user where id = 1 or email = 'mohit@gmail.com'");
        $this->entityManager->getConnection()->executeQuery("DELETE FROM user where id = 2 or email = 'ashish@gmail.com'");
        $roles = json_encode(array('ROLE_ADMIN'));
        $password = $this->passwordEncoder->encodePassword(new User(), 123456);

        $uuid = Uuid::uuid1();
        $this->entityManager->getConnection()->executeQuery("INSERT INTO user (id, uuid, balance, name, email, mobile, password, roles) 
                            values (1, '$uuid', '1000', 'mohit', 'mohit@gmail.com', '9999345816', '$password','$roles')");
        $uuid = Uuid::uuid1();
        $this->entityManager->getConnection()->executeQuery("INSERT INTO user (id, uuid, balance, name, email, mobile, password, roles) 
                            values (2, '$uuid', '0', 'ashish', 'ashish@gmail.com', '9811002233', '$password','$roles')");
    }

    /**
     * @BeforeScenario  @GetTransactionDetails
     */
    public function insertGetTransactionDetailsinDatabase(): void
    {
        $this->entityManager->getConnection()->executeQuery("DELETE FROM user where id = 1 or email = 'mohit@gmail.com'");
        $this->entityManager->getConnection()->executeQuery("DELETE FROM user where id = 2 or email = 'ashish@gmail.com'");
        $roles = json_encode(array('ROLE_ADMIN'));
        $password = $this->passwordEncoder->encodePassword(new User(), 123456);

        $uuid = Uuid::uuid1();
        $this->entityManager->getConnection()->executeQuery("INSERT INTO user (id, uuid, balance, name, email, mobile, password, roles) 
                            values (1, '$uuid', '1000', 'mohit', 'mohit@gmail.com', '9999345816', '$password','$roles')");
        $uuid = Uuid::uuid1();
        $this->entityManager->getConnection()->executeQuery("INSERT INTO user (id, uuid, balance, name, email, mobile, password, roles) 
                            values (2, '$uuid', '0', 'ashish', 'ashish@gmail.com', '9811002233', '$password','$roles')");

        $this->entityManager->getConnection()->executeQuery("DELETE FROM transaction where id = 1 or (sender_id = 1 and receiver_id = 2 and amount =100)");
        $this->entityManager->getConnection()->executeQuery("INSERT INTO transaction (id, uuid, sender_id, receiver_id, amount, type) 
                            values (1, '$uuid', '1', NULL ,'100', '2')");
    }
    /**
     * @BeforeScenario  @GetTransactionListing
     */
    public function insertGetTransactionListinginDatabase(): void
    {
        $this->entityManager->getConnection()->executeQuery("DELETE FROM user where id = 1 or email = 'mohit@gmail.com'");
        $this->entityManager->getConnection()->executeQuery("DELETE FROM user where id = 2 or email = 'ashish@gmail.com'");
        $roles = json_encode(array('ROLE_ADMIN'));
        $password = $this->passwordEncoder->encodePassword(new User(), 123456);

        $uuid = Uuid::uuid1();
        $this->entityManager->getConnection()->executeQuery("INSERT INTO user (id, uuid, balance, name, email, mobile, password, roles) 
                            values (1, '$uuid', '1000', 'mohit', 'mohit@gmail.com', '9999345816', '$password','$roles')");
        $uuid = Uuid::uuid1();
        $this->entityManager->getConnection()->executeQuery("INSERT INTO user (id, uuid, balance, name, email, mobile, password, roles) 
                            values (2, '$uuid', '0', 'ashish', 'ashish@gmail.com', '9811002233', '$password','$roles')");

        $this->entityManager->getConnection()->executeQuery("DELETE FROM transaction where id = 1 or (sender_id = 1 and receiver_id = 2 and amount =100)");
        $this->entityManager->getConnection()->executeQuery("INSERT INTO transaction (id, uuid, sender_id, receiver_id, amount, type) 
                            values (1, '$uuid', '1', '2','100', '2')");
    }


}