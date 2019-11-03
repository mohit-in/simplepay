<?php


namespace App\Tests\Scenario\Context;

use App\Tests\Scenario\Traits\UserTrait;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class APIContext
 * @package App\Tests\Scenario
 */
class APIContext implements Context
{
    use UserTrait;
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var
     */
    private $connection;

    /**
     * APIContext constructor.
     * @param string $baseUrl
     * @param ContainerInterface $container
     */
    public function __construct($baseUrl, ContainerInterface $container)
    {
        $this->connection = $container->get('doctrine.orm.entity_manager')->getConnection();
        $this->baseUrl = $baseUrl;
    }
    /**
     * @When I send a :requestMethod request to :requestUri
     * @param string $requestMethod
     * @param string $requestUri
     * @throws GuzzleException
     */
    public function iSendARequestTo($requestMethod, $requestUri)
    {
        $this->request($requestMethod,$requestUri);
    }

    /**
     * @When I send a :requestMethod request to :requestUri with data
     * @param string $requestMethod
     * @param string $requestUri
     * @param PyStringNode $string
     * @throws GuzzleException
     */
    public function iSendARequestToWithData($requestMethod, $requestUri, PyStringNode $string)
    {

        $this->request($requestMethod,$requestUri,$string);
    }

    /**
     * function to send request
     * @param string $httpMethod
     * @param string $requestUri
     * @param PyStringNode|null $payLoad
     * @throws GuzzleException
     */
    public function request($httpMethod, $requestUri,PyStringNode $payLoad = null)
    {
        $httpMethod = strtoupper($httpMethod);
        $urlPrefix = "v1";
        try {
            $client = new Client([
                'base_uri' => $this->baseUrl
            ]);
            $this->response = $client->request(
                $httpMethod,
                $urlPrefix.$requestUri,
                ['json' => json_decode($payLoad)]
            );
        }
        catch (RequestException $e) {

            if ($e->hasResponse()) {
                $this->response = $e->getResponse();
            }
        }
    }
    /**
     * @Then the response code should :responseStatusCode
     * @param $responseStatusCode
     */
    public function theResponseCodeShould($responseStatusCode)
    {
        if ($responseStatusCode != $this->response->getStatusCode()){
            throw new HttpException(200,"Test Fails..");
        }
    }

    /**
     * @Then the response has property :propertyName :propertyValue
     * @param $propertyName
     * @param $propertyValue
     */
    public function theResponseHasProperty($propertyName, $propertyValue)
    {
        $responseData = json_decode($this->response->getBody(),true);
        if ($propertyValue != $responseData[$propertyName]){
            throw new HttpException(200,"Test Fails..");
        }
    }
}
