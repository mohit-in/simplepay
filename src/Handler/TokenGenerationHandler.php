<?php


namespace App\Handler;


use App\Command\TokenGenerationCommand;
use App\Service\UserService;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class TokenGenerationHandler
 */
class TokenGenerationHandler
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * TokenGenerationHandler constructor.
     *
     * @param ContainerInterface $container
     * @param UserService $userService
     */
    public function __construct(ContainerInterface $container, UserService $userService)
    {
        $this->container = $container;
        $this->userService = $userService;
    }

    /**
     * Handle to token generation command.
     *
     * @param TokenGenerationCommand $command
     *
     * @return string $token
     *
     * @throws JWTEncodeFailureException
     */
    public function __invoke(TokenGenerationCommand $command)
    {
        /* Find and verify user by email and password */
        $user = $this->userService->findUserByEmailPassword($command->getEmail(), $command->getPassword());

        $token = $this->container->get('lexik_jwt_authentication.encoder')
            ->encode([
                'id' => $user->getId(),
                'exp' => time() + 3600 // 1 hour expiration
            ]);

        return $token;
    }
}