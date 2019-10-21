<?php


namespace App\Tests\Scenario;


use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class APIContext
 * @package App\Tests\Scenario
 */
final class APIContext implements Context
{
    /**
     * @var string|null
     */
    private $baseUrl;

    /**
     * @var PyStringNode|null
     */
    private $payload;

    /**
     * @var Response|null
     */
    private $response;

    /**
     * APIContext constructor.
     */
    public function __construct()
    {
        //dump($base_url);exit;
        //$this->baseUrl = $baseUrl;
    }

    /**
     * @Given I have the payload:
     * @param PyStringNode $string
     */
    public function iHaveThePayload(PyStringNode $string)
    {
        $this->payload = $string;
    }

    /**
     * @When I request :arg1
     * @param $arg1 string|null
     */
    public function iRequest($arg1)
    {
        $client = HttpClient::create();
        $this->response = $client->request('GET', $arg1);
    }

    /**
     * @Then the response status code should be :arg1
     * @param $arg1
     */
    public function theResponseStatusCodeShouldBe($arg1)
    {
        if ($arg1 != $this->response->getStatusCode()){

            throw new HttpException(200,"Test Fails..");
        }
    }
















}