<?php


namespace App\Tests\Unit;


use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TransactionTest extends KernelTestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Uuid
     */
    private $uuid;

    protected function setUp() :void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->entityManager->getConnection()->beginTransaction();
        $this->uuid = Uuid::uuid4();
        $roles = json_encode(array('ROLE_ADMIN'));
        $this->entityManager->getConnection()->executeQuery("");


        $this->entityManager->getConnection()
            ->executeQuery(
                "INSERT INTO user(name,uuid,mobile,email,password,status,roles) values(
                    'mohit','$this->uuid','9999345816','mohit@gmail.com','123','active','$roles')");
    }

    /* Function to test findTransactionList funtion of TransactionRepository*/
    public function testFindTransactionList(): void
    {
        $users = $this->entityManager
            ->getRepository(TransactionRepository::class)
            ->findTransactionList();
        $this->assertSame("mohit", $users[0]->getName());
    }
    protected function tearDown(): void
    {
        $this->entityManager->getConnection()->rollback();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}