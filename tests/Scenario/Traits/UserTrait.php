<?php

namespace App\Tests\Scenario\Traits;

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
    public function deleteUser()
    {
        $this->entityManager->getConnection()->executeQuery("DELETE FROM user where email = 'mohit@gmail.com'");
    }

    /**
     * @BeforeScenario  @GetUserDetails
     */
    public function getUserDetailsHook()
    {
        $this->insertUserInTheDatabase();
    }

    /**
     * @BeforeScenario @UpdateUserDetails
     */
    public function updateUserDetailsHook()
    {
        $this->insertUserInTheDatabase();
    }
    /**
     * @BeforeScenario @DeleteUser
     */
    public function deleteUserHook()
    {
        $this->insertUserInTheDatabase();
    }
    private function insertUserInTheDatabase() {

        $this->entityManager->getConnection()->executeQuery("DELETE FROM user where id = 1 or email = 'mohit@gmail.com'");
        $uuid = Uuid::uuid1();
        $roles = json_encode(array('ROLE_ADMIN'));
        $this->entityManager->getConnection()->executeQuery("INSERT INTO user (id, uuid, name, email, mobile, password, roles) 
                            values (1, '$uuid', 'mohit', 'mohit@gmail.com', '9999345816', '123456','$roles')");
    }

}