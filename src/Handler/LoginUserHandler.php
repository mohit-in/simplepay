<?php


namespace App\Handler;


use App\Command\LoginUserCommand;
use App\Service\UserService;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\LcobucciJWTEncoder;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class TokenGenerationHandler
 */
class LoginUserHandler
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var ContainerInterface
     */
    private $JWTEncoder;

    /**
     * TokenGenerationHandler constructor.
     *
     * @param ContainerInterface $container
     * @param UserService $userService
     * @param JWTEncoderInterface $JWTEncoder
     */
    public function __construct(ContainerInterface $container, UserService $userService, JWTEncoderInterface $JWTEncoder)
    {
        $this->userService = $userService;
        $this->JWTEncoder = $JWTEncoder;
    }

    /**
     * Handle to token generation command.
     *
     * @param LoginUserCommand $command
     *
     * @return string $token
     *
     * @throws JWTEncodeFailureException
     */
    public function __invoke(LoginUserCommand $command)
    {
        /* Find and verify user by email and password */
        $user = $this->userService->findUserByEmailPassword($command->getEmail(), $command->getPassword());

        $token = $this->JWTEncoder
            ->encode([
                'id' => $user->getId(),
                'exp' => time() + 3600 // 1 hour expiration
            ]);

        return $token;
    }
}