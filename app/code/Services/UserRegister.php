<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services;

use Romchik38\Site1\Api\Services\UserRegisterInterface;
use Romchik38\Site1\Api\Models\User\UserRepositoryInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Api\Models\DTO\RegisterDTOInterface;
use Romchik38\Site1\Api\Services\RequestInterface;

class UserRegister implements UserRegisterInterface {

    protected array $patterns = [
        RequestInterface::USERNAME_FIELD => '[A-Za-z0-9_]{3,20}$',
        RequestInterface::PASSWORD_FIELD => '^(?=.*[_`$%^*\'])(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[A-Za-z0-9_`$%^*\']{8,}$',
        RequestInterface::FIRST_NAME_FIELD => '^[\p{L}]{3,30}$',
        RequestInterface::LAST_NAME_FIELD => '^[\p{L}]{3,30}$',
        RequestInterface::EMAIL_FIELD => '[A-Za-z0-9.]+@[A-Za-z0-9]\.[a-z]{2,}'
    ];

    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {  
    }

    /**
     * check if username is available
     *
     * @param string $username
     * @return boolean [false not availible, true - available]
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

    public function checkUserInformation(RegisterDTOInterface $userRegisterDTO): void
    {
        $providedUserData = $userRegisterDTO->getAllData();

    }

    public function register(): void
    {
        
    }
}