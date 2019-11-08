<?php


namespace App\Command;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class TokenGenerationCommand
 */
class LoginUserCommand
{
    /**
     * @var string $email
     *
     * @Assert\NotNull(message="Email must not be empty")
     *
     * @Serializer\Type("string")
     */
    private $email;

    /**
     * @var string $password
     *
     * @Assert\NotNull(message="Password must not be empty")
     * @Assert\Length(min="6", minMessage="Password must be greater than or equal to six digit in length")
     *
     * @Serializer\Type("string")
     */
    private $password;

    /**
     * TokenGenerationCommand constructor.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->email = $parameters['email'] ?? null;
        $this->password = $parameters['password'] ?? null;
    }

    /**
     * Get Email.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Get Password.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }


}