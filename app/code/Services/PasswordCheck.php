<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services;

use Romchik38\Site1\Api\Services\PasswordCheckInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Api\Models\User\UserRepositoryInterface;

class PasswordCheck implements PasswordCheckInterface {

    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {  
    }

    /**
     * Return User Id or 0 on fail
     */
    public function checkCredentials(string $userName, string $password): int {
        try {
            $user = $this->userRepository->getByUserName($userName);
            if (password_verify($password, $user->getPassword()) === true) {
                return $user->getId();
            } else {
                return 0; 
            }
        } catch (NoSuchEntityException $e) {
            return 0;
        }
    }
}