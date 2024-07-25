<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Changepassword;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Controllers\Errors\NotFoundException;
use Romchik38\Site1\Api\Services\RequestInterface;
use Romchik38\Site1\Api\Services\UserRecoveryEmailInterface;

class Index implements ControllerInterface
{
    private array $methods = [
        'index',
        'recovery'
    ];

    public function __construct(
        protected RequestInterface $request,
        protected UserRecoveryEmailInterface $userRecoveryEmail
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
        $emailHash = $this->request->getEmailHash();
        $email = $this->request->getEmail();
        if ($emailHash === '' || $email === '') {
            return 'Bad request (email hash or email not present)';
        }
        // 1 check hash


        // 2 auth user
        // 3 redirect to /changepassword/index to change a password
        return htmlentities($emailHash);
    }
}
