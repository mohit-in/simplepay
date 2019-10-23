<?php


namespace App\Tests\Scenario\Traits;


trait BaseTrait
{
    use \Behat\Symfony2Extension\Context\KernelDictionary;

    public $entityManager;

    public function __construct() {

        $this->entityManager = $this->getContainer()->get('doctrine')->getManager();
    }
    public static function checkUserByEmail()
    {

    }


}