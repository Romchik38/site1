<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services;

use Romchik38\Site1\Api\Services\UserRegisterInterface;
use Romchik38\Site1\Api\Models\User\UserRepositoryInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;

class UserRegister implements UserRegisterInterface {

    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {  
    }

    /**
     * check if username is available
     *
     * @param string $username
     * @return boolean [false not availible, true - availablr]
     */
    public function checkAvailableUsername(string $username): bool
    {
        try {
            $user = $this->userRepository->getByUserName($username);
            // username not available
            return false;
        } catch (NoSuchEntityException $e){
            // username available
            return true;
        }
    }

    public function checkUserInformation(): void
    {
        
    }

    public function register(): void
    {
        
    }
}