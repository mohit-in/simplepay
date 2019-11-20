<?php

namespace App\Tests\Scenario\Traits;

use App\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use Ramsey\Uuid\Uuid;

/**
 * Trait UserTrait
 * @package App\Tests\Scenario\Traits
 */
trait UserTrait
{
    /**
     * @BeforeScenario  @CreateUser
     */
    public function deleteUser(): void
    {
        $this->entityManager->getConnection()->executeQuery("DELETE FROM user where email = 'mohit@gmail.com'");
    }

    /**
     * @BeforeScenario  @GetUserDetails
     */
    public function getUserDetailsHook(): void
    {
        $this->insertUserInTheDatabase();
    }

    /**
     * @BeforeScenario @UpdateUserDetails
     */
    public function updateUserDetailsHook(): void
    {
        $this->insertUserInTheDatabase();
    }

    /**
     * @BeforeScenario @DeleteUser
     */
    public function deleteUserHook(): void
    {
        $this->insertUserInTheDatabase();
    }

    /**
     * @BeforeScenario @LoginUser
     */
    public function loginUserHook(): void
    {
        $this->insertUserInTheDatabase();
    }

    private function insertUserInTheDatabase(): void
    {
        $this->entityManager->getConnection()->executeQuery("DELETE FROM user where id = 1 or email = 'mohit@gmail.com'");
        $uuid = Uuid::uuid1();
        $roles = json_encode(array('ROLE_ADMIN'));
        $password = $this->passwordEncoder->encodePassword(new User(), 123456);
        $this->entityManager->getConnection()->executeQuery("INSERT INTO user (id, uuid, name, email, mobile, password, roles) 
                            values (1, '$uuid', 'mohit', 'mohit@gmail.com', '9999345816', '$password','$roles')");
    }

}