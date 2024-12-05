<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\UserChangePassword;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Romchik38\Server\Models\Errors\CouldNotSaveException;
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Domain\User\UserModelInterface;
use Romchik38\Site1\Domain\User\UserRepositoryInterface;
use Romchik38\Site1\Domain\User\VO\Id;
use Romchik38\Site1\Domain\User\VO\Password;

final class UserChangePasswordService
{
    public function __construct(
        protected readonly UserRepositoryInterface $userRepository,
        protected readonly LoggerInterface $logger
    ) {}

    /**
     * @throws InvalidArgumentException
     * @throws CouldNonChangePassword
     */
    public function changePassword(Change $command): bool
    {
        $id = new Id($command->userId);
        $password = new Password($command->password);

        try {
            /** @var UserModelInterface $user */
            $user = $this->userRepository->getById($id());
            $user->setPassword(password_hash($password(), PASSWORD_DEFAULT));
            try {
                $this->userRepository->save($user);
                return true;
            } catch (CouldNotSaveException $e) {
                $this->logger->log(LogLevel::ERROR, sprintf(
                    'Cannot save a password for user with id %s: %s',
                    $id(),
                    $e->getMessage()
                ));
                throw new CouldNonChangePassword('Could not save changed password');
            }
        } catch (NoSuchEntityException $e) {
            $this->logger->log(LogLevel::ERROR, sprintf(
                'User with id: %s wants to change password, but it is not present in the User Repository',
                $id()
            ));
            throw new CouldNonChangePassword('Cannot change password, user not present');
        }
    }
}
