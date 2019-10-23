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
    }

    public function testFindByEmail()
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findByEmail("mohit@gmail.com");

        dump($user[0]['name']);exit;
        $this->assertSame(9999345816, $user['mobile']);
    }


    protected function tearDown()
    {
        parent::tearDown();
        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}