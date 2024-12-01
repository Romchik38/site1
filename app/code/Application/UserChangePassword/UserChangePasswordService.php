<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\UserChangePassword;

use Psr\Log\LoggerInterface;
use Romchik38\Site1\Domain\User\UserRepositoryInterface;

final class UserChangePassword{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected LoggerInterface $logger
    ) {}

        /**
     * Check provided password for password change
     *
     * @param string $password
     * @throws IncorrectFieldError
     * @return void
     */
    public function checkPasswordChange(string $password): void
    {
        [$pattern, $message] = $this->patterns[RequestInterface::PASSWORD_FIELD];
        $check = preg_match($pattern, $password);
        if ($check === 0 || $check === false) {
            throw new IncorrectFieldError('Check field: ' . $message);
        }
    }

    public function changePassword(int $userId, string $password): bool
    {
        try {
            /** @var UserModelInterface $user */
            $user = $this->userRepository->getById($userId);
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
            try {
                $this->userRepository->save($user);
                return true;
            } catch (CouldNotSaveException $e) {
                $this->logger->log(LogLevel::ERROR, self::class . ' - Can not save a password for user with id: ' . $userId . '. User Repository says: ' . $e->getMessage());
                return false;
            }
        } catch (NoSuchEntityException $e) {
            $this->logger->log(LogLevel::ERROR, self::class . ' - User with id: ' . $userId . ' wants to change password, but it is not present in the User Repository');
            return false;
        }
    }
}