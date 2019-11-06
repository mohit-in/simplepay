<?php


namespace App\Tests\Scenario\Context;

use App\Entity;
use App\Tests\Scenario\Traits\UserTrait;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Exception\InvalidArgumentException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\Assert;
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
    private $entityManager;

    /**
     * APIContext constructor.
     * @param string $baseUrl
     * @param ContainerInterface $container
     */
    public function __construct($baseUrl, ContainerInterface $container)
    {
        $this->entityManager = $container->get('doctrine.orm.entity_manager');
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
        $this->request($requestMethod, $requestUri);
    }

    /**
     * @When I send a :requestMethod request to :requestUri with data
     * @param string $requestMethod
     * @param string $requestUri
     * @param PyStringNode $string
     * @throws GuzzleException
     */
    public function iSendARequestToWithData ($requestMethod, $requestUri, PyStringNode $string)
    {
        $this->request($requestMethod, $requestUri,$string);
    }

    /**
     * Funtion to check entity for Given and Then scenario
     *
     * @Given  I have an entity :entity with :arguments
     * @param $entity
     * @param $arguments
     */
    public function iHaveAnEntityWith($entity, $arguments)
    {
        Assert::assertCount(1, $this->getResultByEntity($entity, $arguments));
    }

    /**
     * Funtion to check entity for Given and Then scenario
     * 
     * @Given I do not have an entity :entity with :arguments
     * @param $entity
     * @param $arguments
     */
    public function iDoNotHaveAnEntityWith($entity, $arguments)
    {
        Assert::assertCount(0,$this->getResultByEntity($entity, $arguments));
    }

    /**
     * Function to return query data.
     *
     * @param $entity
     * @param $arguments
     *
     * @return mixed
     */
    private function getResultByEntity($entity, $arguments)
    {
        parse_str($arguments, $arguments);
        $qb = $this->entityManager->createQueryBuilder()
            ->select('ent.id')
            ->from('App\\Entity\\'.$entity, 'ent');
        foreach ($arguments as $key => $value) {
            $qb->andWhere("ent." . $key . " = '$value'");
        }
        return $qb->getQuery()->getResult();
    }

    /**
     * function to send request
     * @param string $httpMethod
     * @param string $requestUri
     * @param PyStringNode|null $payLoad
     * @throws GuzzleException
     */
    public function request($httpMethod, $requestUri, PyStringNode $payLoad = null)
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
        } catch (RequestException $e) {
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
        Assert::assertEquals($responseStatusCode, $this->response->getStatusCode());
    }

    /**
     * @Then the response has property :propertyName :propertyValue
     * @param $propertyName
     * @param $propertyValue
     */
    public function theResponseHasProperty($propertyName, $propertyValue)
    {
        Assert::assertEquals($propertyValue, json_decode($this->response->getBody(),true)[$propertyName]);
    }
}
