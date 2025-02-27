<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Changepassword;

use InvalidArgumentException;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Psr\Log\LoggerInterface;
use \Romchik38\Site1\Api\Services\SessionInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Domain\User\UserRepositoryInterface;
use Psr\Log\LogLevel;
use Romchik38\Server\Controllers\Actions\AbstractAction;
use Romchik38\Site1\Application\RecoveryEmail\Check;
use Romchik38\Site1\Application\RecoveryEmail\HashNoValidException;
use Romchik38\Site1\Application\RecoveryEmail\NoSuchEmailException;
use Romchik38\Site1\Application\RecoveryEmail\RecoveryEmailService;
use Romchik38\Site1\Application\UserEmail\FindEmail;
use Romchik38\Site1\Application\UserEmail\UserEmailService;
use Romchik38\Site1\Controllers\Login\Message;
use Romchik38\Site1\Domain\RecoveryEmail\VO\Hash;

final class DefaultAction extends AbstractAction implements DefaultActionInterface
{

    protected $failedMessage = 'Sorry, provided recovery link does\'nt work. It is valid for '
        . (Hash::VALID_TIME / 60) . ' minutes';

    protected $successMessage = 'You are already logged in. Please change a password';
    protected $alreadyLoggedIn = 'You are already logged in';
    protected $technicalProblemMessage = 'We are sorry, you can\'t recovery a password. There are some technical problems on our side.';

    public function __construct(
        protected readonly ServerRequestInterface $request,
        protected readonly RecoveryEmailService $userRecoveryEmail,
        protected readonly SessionInterface $session,
        protected readonly UserRepositoryInterface $userRepository,
        protected readonly LoggerInterface $logger,
        protected readonly UserEmailService $userEmailService
    ) {}

    public function execute(): ResponseInterface
    {
        $response = new Response();
        $responseBody = $response->getBody();
        $message = $this->change();
        $responseBody->write($message);
        $uri = $this->request->getUri();
        $url = sprintf(
            '%s://%s%s?%s=%s', 
            $uri->getScheme(),
            $uri->getAuthority(),
            '/login/changepassword',
            Message::FIELD,
            urlencode($message)
        );
        return $response
            ->withHeader('Location', $url)
            ->withStatus(301)
            ->withBody($responseBody);
    }

    public function getDescription(): string {
        return 'Change password page';
    }

    /** @return string Text message (success or fail) */
    private function change(): string {
        // 1 check user auth
        $userId = $this->session->getUserId();
        if ($userId !== 0) {
            return $this->alreadyLoggedIn;
        }
        // 2 it's a guest, so let's check recovery link
        $check = Check::fromRequest($this->request->getQueryParams());
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
        } catch (NoSuchEntityException) {
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
