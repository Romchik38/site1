<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Changepassword;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Controllers\Actions\Action;
use Psr\Log\LoggerInterface;
use Romchik38\Site1\Api\Services\RequestInterface;
use \Romchik38\Site1\Api\Services\SessionInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Domain\User\UserRepositoryInterface;

use Psr\Log\LogLevel;
use Romchik38\Site1\Application\RecoveryEmail\RecoveryEmailService;
use Romchik38\Site1\Domain\RecoveryEmail\VO\Hash;

/** @todo Refactor */
class DefaultAction extends Action implements DefaultActionInterface
{

    protected $failedMessage = 'Sorry, provided recovery link does\'nt work. It is valid for '
        . (Hash::VALID_TIME / 60) . ' minutes';

    protected $successMessage = 'You are already logged in. Please change a password';
    protected $alreadyLoggedIn = 'You are already logged in';
    protected $technicalProblemMessage = 'We are sorry, you can\'t recovery a password. There are some technical problems on our side.';

    public function __construct(
        protected RequestInterface $request,
        protected RecoveryEmailService $userRecoveryEmail,
        protected SessionInterface $session,
        protected UserRepositoryInterface $userRepository,
        protected LoggerInterface $logger
    ) {}

    public function execute(): string
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
        } catch (NoSuchEntityException $e) {
            // there is a problem. Because a recovery row exist, but user do not exist.
            $this->logger->log(LogLevel::ERROR, 'user with email ' . $email . ' does\'nt exist. But recovery row the email is present.');
            return $this->technicalProblemMessage;
        }

        $this->session->setUserId($user->getId());
        // 5 redirect to /changepassword/index to change a password
        return $this->successMessage;
    }
}
