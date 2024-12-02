<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\UserPasswordCheck;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Domain\User\UserRepositoryInterface;
use Romchik38\Site1\Domain\User\VO\Password;
use Romchik38\Site1\Domain\User\VO\Username;

final class UserPasswordCheckService
{
    public function __construct(
        protected readonly UserRepositoryInterface $userRepository
    ) {}

    /**
     * Return User Id or 0 on fail
     */
    public function checkCredentials(Credentials $command): int
    {
        $password = new Password($command->password);

        try {
            $user = $this->userRepository
                ->getByUserName(new Username($command->password));
            if (password_verify($password(), $user->getPassword()) === true) {
                return $user->getId();
            } else {
                return 0;
            }
        } catch (NoSuchEntityException $e) {
            return 0;
        }
    }
}
