<?php

namespace App\Tests\Scenario\Traits;

/**
 * Trait UserTrait
 * @package App\Tests\Scenario\Traits
 */
trait UserTrait
{
    /** @BeforeScenario @CreateUser
     */
    public function checkUserByEmail()
    {
        #$this->connection->executeQuery("DELETE FROM user where email = 'mohit@gmail.com'");
        $this->connection->executeQuery("truncate user");
    }

}