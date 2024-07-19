<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services;

use Romchik38\Site1\Api\Services\UserRegisterInterface;
use Romchik38\Site1\Api\Models\User\UserRepositoryInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Api\Models\DTO\UserRegisterDTOInterface;
use Romchik38\Site1\Api\Services\RequestInterface;
use Romchik38\Site1\Services\Errors\UserRegister\IncorrectFieldError;
use Romchik38\Site1\Api\Models\User\UserModelInterface;

class UserRegister implements UserRegisterInterface {

    protected array $patterns = [
        RequestInterface::USERNAME_FIELD => [
            '/' . RequestInterface::USERNAME_PATTERN . '/', 
            RequestInterface::USERNAME_ERROR_MESSAGE
        ],
        RequestInterface::PASSWORD_FIELD => [
            '/' . RequestInterface::PASSWORD_PATTERN . '/',
            RequestInterface::PASSWORD_ERROR_MESSAGE
        ],
        RequestInterface::FIRST_NAME_FIELD => [
            '/' . RequestInterface::FIRST_NAME_PATTERN . '/u',
            RequestInterface::FIRST_NAME_ERROR_MESSAGE
        ],
        RequestInterface::LAST_NAME_FIELD => [
            '/' . RequestInterface::LAST_NAME_PATTERN . '/u',
            RequestInterface::LAST_NAME_ERROR_MESSAGE
        ],
        RequestInterface::EMAIL_FIELD => [
            '/' . RequestInterface::EMAIL_PATTERN . '/',
            RequestInterface::EMAIL_ERROR_MESSAGE
        ]
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
            // username is not available
            return false;
        } catch (NoSuchEntityException $e){
            // username is available
            return true;
        }
    }

    /** 
     * Check provided user information. 
     * throws error if a check doesn't pass
     * 
     * @throws IncorrectFieldError
     */
    public function checkUserInformation(UserRegisterDTOInterface $userRegisterDTO): void
    {
        $providedUserData = $userRegisterDTO->getAllData();
        foreach($this->patterns as $key => [$pattern, $message]) {
             $fieldValue = $providedUserData[$key] ?? null;
            // 1. check if a field is present in request
            if ($fieldValue === null) {
                throw new IncorrectFieldError('Bad request ( ' . $key . ' )');
            } 
            // 2. Pattern check 
            $check = preg_match($pattern, $fieldValue);
            if ($check === 0 || $check === false) {
                throw new IncorrectFieldError('Check field: ' . $message);
            }
        }
        // 3. any errors user sent correct data
    }

    public function register(UserRegisterDTOInterface $userRegisterDTO): UserModelInterface
    {

        $newUser = $this->userRepository->create();
        $providedUserData = $userRegisterDTO->getAllData();
        $password = $providedUserData[RequestInterface::PASSWORD_FIELD];
        $newUser
            ->setUserName($providedUserData[RequestInterface::USERNAME_FIELD])
            ->setPassword(password_hash($password, PASSWORD_DEFAULT))
            ->setFirstName($providedUserData[RequestInterface::FIRST_NAME_FIELD])
            ->setLastName($providedUserData[RequestInterface::LAST_NAME_FIELD])
            ->SetEmail($providedUserData[RequestInterface::EMAIL_FIELD]);
        
        return $this->userRepository->add($newUser);
    }
}