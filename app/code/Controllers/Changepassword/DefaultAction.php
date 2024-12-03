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
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Site1\Application\RecoveryEmail\Check;
use Romchik38\Site1\Application\RecoveryEmail\HashNoValidException;
use Romchik38\Site1\Application\RecoveryEmail\NoSuchEmailException;
use Romchik38\Site1\Application\RecoveryEmail\RecoveryEmailService;
use Romchik38\Site1\Application\UserEmail\FindEmail;
use Romchik38\Site1\Application\UserEmail\UserEmailService;
use Romchik38\Site1\Domain\RecoveryEmail\VO\Hash;

final class DefaultAction extends Action implements DefaultActionInterface
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
        protected LoggerInterface $logger,
        protected readonly UserEmailService $userEmailService
    ) {}

    public function execute(): string
    {
        // 1 check user auth
        $userId = $this->session->getUserId();
        if ($userId !== 0) {
            return $this->alreadyLoggedIn;
        }
        // 2 it's a guest, so let's check recovery link
        $check = Check::fromRequest($this->request->getParsedBody());
        try {
            $this->userRecoveryEmail->checkHash($check);
        } catch (InvalidArgumentException) {
            return 'Bad request. Please visit recovery page and try again.';
        } catch (HashNoValidException) {
            return $this->failedMessage;
        } catch (NoSuchEmailException) {
            return 'Provided email doesn\'t exist';
        }
        // 3 auth user
        try {
            $user = $this->userEmailService->checkEmailForAuth(
                FindEmail::fromString($check->email)
            );
        } catch (NoSuchEntityException $e) {
            // there is a problem. Because a recovery row exist, but user do not exist.
            $this->logger->log(
                LogLevel::ERROR,
                sprintf(
                    'user with email %s does\'nt exist. But recovery row the email is present.',
                    $check->email
                )
            );
            return $this->technicalProblemMessage;
        }
        $this->session->setUserId($user->id);
        return $this->successMessage;
    }
}
