<?php

declare(strict_types=1);

namespace Romchik38\Server\Services;

use Romchik38\Server\Api\Services\PasswordCheckInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Api\Models\User\UserRepositoryInterface;

class PasswordCheck implements PasswordCheckInterface {

    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {
        
    }
    public function checkCredentials(string $userName, string $password): bool {
        try {
            $user = $this->userRepository->getByUserName($userName);
            if ($password === $user->getPassword()) {
                return true;
            } else {
                return false; 
            }
        } catch (NoSuchEntityException $e) {
            return false;
        }
    }
}