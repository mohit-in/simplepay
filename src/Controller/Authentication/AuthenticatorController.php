<?php


namespace App\Controller\Authentication;

use App\Command\TokenGenerationCommand;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;


/**
 * Class TokenController
 */
class AuthenticatorController extends FOSRestController
{

    /**
     * @var MessageBusInterface $messageBus
     */
    private $messageBus;

    /**
     * TokenController constructor.
     *
     * @param MessageBusInterface $messageBus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * Function to handle token generation request.
     *
     * @Rest\Post("/user" , name="create_token")
     *
     * @param Request $request
     *
     * @return View
     *
     */
    public function generateToken(Request $request): View
    {
        try {
            $envelope = $this->messageBus->dispatch( //call token generation command
                new TokenGenerationCommand(
                    $request->request->all()
                )
            );
            $token = $envelope->last(HandledStamp::class)->getResult(); // return token
        } catch (ValidationFailedException $exception) {
            throw new BadRequestHttpException($exception->getViolations()->get(0)->getMessage());
        }

        return View::create($token, Response::HTTP_CREATED);
    }

}