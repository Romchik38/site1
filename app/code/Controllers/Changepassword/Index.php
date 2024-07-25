<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Changepassword;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Controllers\Errors\NotFoundException;
use Romchik38\Site1\Api\Services\RequestInterface;
use Romchik38\Site1\Api\Services\UserRecoveryEmailInterface;
use Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailInterface;
use Romchik38\Server\Api\Services\SessionInterface;
use Romchik38\Server\Services\Session;

class Index implements ControllerInterface
{
    private array $methods = [
        'index',
        'recovery'
    ];

    protected $failedMessage = 'Sorry, provided recovery link does\'nt work. It is valid ' 
        . (RecoveryEmailInterface::VALID_TIME / 60) . ' minutes';

    protected $successMessage = 'Link is valid';
    protected $alreadyLoggedIn = 'You are already logged in';

    public function __construct(
        protected RequestInterface $request,
        protected UserRecoveryEmailInterface $userRecoveryEmail,
        protected SessionInterface $session
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

        // 5 redirect to /changepassword/index to change a password
        return $this->successMessage;
    }
}
