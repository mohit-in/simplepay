<?php


namespace App\Service;
use App\Entity\Transaction;
use App\Entity\User;
use App\Repository\TransactionRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;


use App\Security\Authenticator;

/**
 * Class TransactionService
 * @package App\Service
 */
class TransactionService
{
    /**
     * @var Security
     */
    private $security;
    /**
     * @var TransactionRepository
     */
    private $transactionRepository;

    /**
     * TransactionService constructor.
     * @param Security $security
     * @param TransactionRepository $transactionRepository
     */
    public function __construct(Security $security, TransactionRepository $transactionRepository)
    {
        $this->security = $security;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Function to validate query parameters of transaction listing api.
     *
     * @param array $parameters
     *
     * @return array
     */
    public function validateParameters(array $parameters = []): array
    {
        $validatedParameters = [];
        if (isset($parameters['senderId'])) {
            /* validation role of user */
            if ($this->security->isGranted('ROLE_ADMIN')
                || $this->security->getUser()->getId() !== (int)$parameters['senderId']
            ) {
                throw new NotFoundHttpException(
                    sprintf('User does not exists with SenderId: %d', $parameters['senderId'])
                );
            }
            $validatedParameters['senderId'] = explode(', ', trim($parameters['senderId'], ','));
            if (!array_filter($validatedParameters['senderId'], 'is_numeric')) {
                throw new BadRequestHttpException(sprintf('SenderId must be in proper format'));
            }
        }
        if (isset($parameters['receiverId'])) {
            $validatedParameters['receiverId'] = explode(', ', trim($parameters['receiverId'], ','));
            if (!array_filter($validatedParameters['receiverId'], 'is_numeric')) {
                throw new BadRequestHttpException(sprintf('ReceiverId must be in proper format'));
            }
        }

        $possibleOrder = array('id', 'amount');
        $validatedParameters['orderBy'] = array();
        if(isset($parameters['orderBy'])) {
            $orderBy = explode(',', $parameters['orderBy']);
            foreach ($orderBy as $value) {
                if (in_array(ltrim($value, '- +'), $possibleOrder, true)) {
                    $validatedParameters['orderBy'][ltrim($value, '- +')] =
                        strpos($value, '-') === 0
                        ? 'desc' : 'asc' ;
                }
            }
        }
        if (!array_key_exists('id', $validatedParameters['orderBy'])) {
            $validatedParameters['orderBy']['id'] = 'desc';
        }

        $validatedParameters['offset'] = 0;
        if (isset($parameters['offset']) && 1000 > $parameters['offset']) {
            $validatedParameters['offset'] = $parameters['offset'];
        }

        $validatedParameters['limit'] = 30;
        if (isset($parameters['limit']) && 100 > $parameters['limit']) {
            $validatedParameters['limit'] = $parameters['limit'];
        }

        return $validatedParameters;
    }

    /**
     * Function to process transaction listing api.
     *
     * @param array $parameters
     *
     * @return mixed
     */
    public function findTransactionList(array $parameters = [])
    {
        return $this->transactionRepository->findTransactionList($parameters);
    }

    /**
     * Function to process transaction details api.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function findTransactionDetails(int $id)
    {
        return $this->transactionRepository->findOneById($id);
    }
}