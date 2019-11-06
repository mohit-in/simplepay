<?php

namespace App\Tests\Unit;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class UserTest extends KernelTestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Uuid
     */
    private $uuid;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->entityManager->getConnection()->beginTransaction();
        $this->uuid = Uuid::uuid4();
        $this->entityManager->getConnection()->executeQuery("DELETE FROM user where email = 'mohit@gmail.com'");
        $this->entityManager->getConnection()->executeQuery("INSERT INTO user(name,uuid,mobile,email,password,status) values('mohit','$this->uuid','9999345816','mohit@gmail.com','123','active')");


    }
    /* Function to test FindByEmail funtion of UserRepository*/
    public function testFindByEmail()
    {
        $users = $this->entityManager
           ->getRepository(User::class)
            ->findByUuid($this->uuid);
        $this->assertSame("mohit", $users[0]->getName());
    }
    protected function tearDown()
    {
        $this->entityManager->getConnection()->rollback();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}