<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Changepassword;

use Psr\Log\LoggerInterface;
use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Controllers\Errors\NotFoundException;
use Romchik38\Site1\Api\Services\RequestInterface;
use Romchik38\Site1\Api\Services\UserRecoveryEmailInterface;
use Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailInterface;
use Romchik38\Server\Api\Services\SessionInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Api\Models\User\UserRepositoryInterface;
use Psr\Log\LogLevel;

class Index implements ControllerInterface
{
    private array $methods = [
        'index',
        'recovery'
    ];

    protected $failedMessage = 'Sorry, provided recovery link does\'nt work. It is valid ' 
        . (RecoveryEmailInterface::VALID_TIME / 60) . ' minutes';

    protected $successMessage = 'You are already logged in. Please change a password';
    protected $alreadyLoggedIn = 'You are already logged in';
    protected $technicalProblemMessage = 'We are sorry, you can\'t recovery a password. There are some technical problems on our side.';

    public function __construct(
        protected RequestInterface $request,
        protected UserRecoveryEmailInterface $userRecoveryEmail,
        protected SessionInterface $session,
        protected UserRepositoryInterface $userRepository,
        protected LoggerInterface $logger
    ) {
    }

    public function execute($action): string
    {
        if (array_search($action, $this->methods) !== false) {
            return $this->$action();
        } else {
            throw new NotFoundException('Sorry, requested resource ' . $action . ' not found');
        }
    }

    /** Action /changepassword/index */
    protected function index()
    {
        // 1 get user
        
        return 'change password page';
    }

    /** Action /changepassword/recover */
    protected function recovery()
    {
        // 1 check user auth
        $userId = $this->session->getUserId();
        if ($userId !== 0) {
            return $this->alreadyLoggedIn;
        }
        // 2 it's a guest, so let's check recovery link
        $emailHash = $this->request->getEmailHash();
        $email = $this->request->getEmail();
        if ($emailHash === '' || $email === '') {
            return 'Bad request (email hash or email not present)';
        }
        // 3 check hash
        $isValid = $this->userRecoveryEmail->checkHash($email, $emailHash);
        if ($isValid === false) {
            return $this->failedMessage;
        }
        // 4 auth user
        try {
            $user = $this->userRepository->getByEmail($email);
        } catch(NoSuchEntityException $e) {
            // there is a problem. Because a recovery row exist, but user do not exist.
            $this->logger->log(LogLevel::ERROR, 'user with email ' . $email . ' does\'nt exist. But recovery row the email is present.');
            return $this->technicalProblemMessage;
        }

        $this->session->setUserId($user->getId());
        // 5 redirect to /changepassword/index to change a password
        return $this->successMessage;
    }
}
