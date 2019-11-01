<?php

namespace App\Tests\Unit;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class UserTest extends KernelTestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->entityManager->getConnection()->executeQuery("DELETE FROM user where email = 'mohit@gmail.com'");
        $this->entityManager->getConnection()->executeQuery("INSERT INTO user(name,mobile,email,password,status) values('mohit','9999345816','mohit@gmail.com','123','active')");
        #$this->entityManager->getConnection()->beginTransaction();

    }
    /* Function to test FindByEmail funtion of UserRepository*/
    public function testFindByEmail()
    {
        $users = $this->entityManager
           ->getRepository(User::class)
            ->findByEmail("mohit@gmail.com");
        $this->assertSame("mohit", $users[0]->getName());
    }
    protected function tearDown()
    {
        parent::tearDown();
        #$this->entityManager->getConnection()->rollback();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}