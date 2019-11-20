<?php


namespace App\Handler;

use App\Command\RegisterUserCommand;
use App\Command\UpdateUserCommand;
use App\Entity\User;

use App\Repository\UserRepository;
use App\Service\UserService;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class SaveUserHandler
 * @package App\MessageHandler
 */
class SaveUserHandler implements MessageSubscriberInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var User
     */
    private $user;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param UserService $userService
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param MailerInterface $mailer
     */
    public function __construct(
        UserRepository $userRepository,
        UserService $userService,
        UserPasswordEncoderInterface $passwordEncoder,
        MailerInterface $mailer
    )
    {
        $this->userRepository = $userRepository;
        $this->userService    = $userService;
        $this->passwordEncoder = $passwordEncoder;
        $this->mailer = $mailer;
    }

    /**
     * @return iterable
     */
    public static function getHandledMessages(): iterable
    {
        yield UpdateUserCommand::class => ['method' => '__invoke'];
        yield RegisterUserCommand::class => ['method' => '__invoke'];
    }

    /**
     * @param $command
     * @return User
     * @throws \Doctrine\ORM\ORMException
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function __invoke($command)
    {
        if (!empty($command->getId())) {
            $this->user = $this->userService->findUserById($command->getId());
        }
        else {
            if (!empty($this->userRepository->findOneByEmail($command->getEmail()))) {
                throw new ConflictHttpException(sprintf('User exists with Email: %s', $command->getEmail()));
            }
            $this->user = $command->getUser();
        }

        if (!empty($command->getUuid())) {
            $this->user->setUuid($command->getUuid());
        }
        if (!empty($command->getName())) {
            $this->user->setName($command->getName());
        }
        if (!empty($command->getEmail())) {
            $this->user->setEmail($command->getEmail());
        }
        if (!empty($command->getMobile())) {
            $this->user->setMobile($command->getMobile());
        }
        if (!empty($command->getPassword())) {
            $this->user->setPassword(
                $this->passwordEncoder->encodePassword($this->user, $command->getPassword()));
        }

        #$this->userRepository->save($this->user);

        if(!$command->getId()) {

            $email = (new Email())
                ->from('admin@simplepay.com')
                ->to($this->user->getEmail())
                ->subject('Thank you email for registration')
                ->html('<p>Hi '.$this->user->getName().',<br> Thanks for registration in simplepay app</p>');

            $this->mailer->send($email);
        }

        return $this->user;
    }
}
