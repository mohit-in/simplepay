<?php

namespace App\Tests\Scenario\Context;

use App\Entity\User;
use App\Tests\Scenario\Traits\UserTrait;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Lcobucci\JWT\Token;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use PHPUnit\Framework\Assert;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
     * @var JWTEncoderInterface
     */
    private  $JWTEncoder;

    /**
     * @var Token
     */
    private $token;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * APIContext constructor.
     * @param string $baseUrl
     * @param ContainerInterface $container
     * @param JWTEncoderInterface $JWTEncoder
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct($baseUrl, ContainerInterface $container, JWTEncoderInterface $JWTEncoder, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $container->get('doctrine.orm.entity_manager');
        $this->baseUrl = $baseUrl;
        $this->JWTEncoder = $JWTEncoder;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @When I send a :requestMethod request to :requestUri
     * @param string $requestMethod
     * @param string $requestUri
     * @throws GuzzleException
     */
    public function iSendARequestTo($requestMethod, $requestUri): void
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
    public function iSendARequestToWithData($requestMethod, $requestUri, PyStringNode $string): void
    {
        $this->request($requestMethod, $requestUri, $string);
    }

    /**
     * @When I set Authentication token in request header with user id :id
     * @param $id
     * @throws JWTEncodeFailureException
     */
    public function iSetAuthenticationTokenInRequestHeaderWithUserId($id): void
    {
        $this->token = $this->JWTEncoder
            ->encode([
                'id' => $id,
                'exp' => time() + 3600 // 1 hour expiration
            ]);
    }

    /**
     * function to send request
     * @param string $httpMethod
     * @param string $requestUri
     * @param PyStringNode|null $payLoad
     * @throws GuzzleException
     */
    public function request($httpMethod, $requestUri, PyStringNode $payLoad = null): void
    {
        try {
            $client = new Client([
                'base_uri' => $this->baseUrl
            ]);
            $this->response = $client->request(
                $httpMethod,
                $requestUri,
                [
                    'headers' =>
                        [
                            'Authorization' => 'Bearer '. $this->token
                        ],
                    'json' => json_decode($payLoad)
                ]
            );
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $this->response = $e->getResponse();
            }
        }
    }

    /**
     * Funtion to check entity for Given and Then scenario
     *
     * @Given  I have an entity :entity with :arguments
     * @param $entity
     * @param $arguments
     */
    public function iHaveAnEntityWith($entity, $arguments): void
    {
        Assert::assertCount(1, $this->getResultByEntity($entity, $arguments));
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
            ->from('App\\Entity\\' . $entity, 'ent');
        foreach ($arguments as $key => $value) {
            if ($key == 'password') {
                $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $arguments['email']]);
                $value = $this->passwordEncoder->encodePassword($user, $value);
            }
            $qb->andWhere("ent." . $key . " = '$value'");
        }
        return  $qb->getQuery()->getResult();
    }

    /**
     * Funtion to check entity for Given and Then scenario
     *
     * @Given I do not have an entity :entity with :arguments
     * @param $entity
     * @param $arguments
     */
    public function iDoNotHaveAnEntityWith($entity, $arguments): void
    {
        Assert::assertCount(0, $this->getResultByEntity($entity, $arguments));
    }

    /**
     * @Then the response code should :responseStatusCode
     * @param $responseStatusCode
     */
    public function theResponseCodeShould($responseStatusCode): void
    {
        Assert::assertEquals($responseStatusCode, $this->response->getStatusCode());
    }

    /**
     * @Then the response has property :propertyName :propertyValue
     * @param $propertyName
     * @param $propertyValue
     */
    public function theResponseHasProperty($propertyName, $propertyValue): void
    {
        Assert::assertEquals($propertyValue, json_decode($this->response->getBody(), true)[$propertyName]);
    }
}