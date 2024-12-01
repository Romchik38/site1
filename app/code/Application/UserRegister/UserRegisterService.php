<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\UserRegister;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Romchik38\Server\Models\Errors\CouldNotSaveException;
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Site1\Domain\User\UserRepositoryInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Api\Models\DTO\UserRegister\UserRegisterDTOInterface;
use Romchik38\Site1\Api\Services\RequestInterface;
use Romchik38\Site1\Services\Errors\UserRegister\IncorrectFieldError;
use Romchik38\Site1\Domain\User\UserModelInterface;
use Romchik38\Site1\Domain\User\VO\Id;
use Romchik38\Site1\Domain\User\VO\Username;

class UserRegisterService
{

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
        protected UserRepositoryInterface $userRepository,
        protected LoggerInterface $logger
    ) {}

    /**
     * check if username is available
     *
     * @return boolean [false not availible, true - available]
     */
    public function checkAvailableUsername(Username $username): bool
    {
        try {
            $this->userRepository->getByUserName($username);
            // username is not available
            return false;
        } catch (NoSuchEntityException $e) {
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
        foreach ($this->patterns as $key => [$pattern, $message]) {
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
        // 3. any error, so user sent correct data
    }

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

    /** @throws InvalidArgumentException on bad request data 
     *  @throws UsernameAlreadyInUseException 
     *  @throws CouldNotRegisterException incorrect data can be showed to user
    */
    public function register(Register $command): Id
    {

        $isAvailable = $this->checkAvailableUsername(new Username($command->username));

        if($isAvailable === false) {
            throw new UsernameAlreadyInUseException(sprintf(
                'Username %s already in use',
                $command->username
            ));
        }

        
        /** @var UserModelInterface $newUser */
        $newUser = $this->userRepository->create();
        $providedUserData = $userRegisterDTO->getAllData();
        $password = $providedUserData[RequestInterface::PASSWORD_FIELD];
        $newUser
            ->setUserName($providedUserData[RequestInterface::USERNAME_FIELD])
            ->setPassword(password_hash($password, PASSWORD_DEFAULT))
            ->setFirstName($providedUserData[RequestInterface::FIRST_NAME_FIELD])
            ->setLastName($providedUserData[RequestInterface::LAST_NAME_FIELD])
            ->SetEmail($providedUserData[RequestInterface::EMAIL_FIELD]);

        /** @var UserModelInterface $savedUser */
        $savedUser = $this->userRepository->add($newUser);

        return new Id($savedUser->getId());
    }
}
