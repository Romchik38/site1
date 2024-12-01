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
use Romchik38\Site1\Domain\User\VO\Email;
use Romchik38\Site1\Domain\User\VO\Firstname;
use Romchik38\Site1\Domain\User\VO\Id;
use Romchik38\Site1\Domain\User\VO\Password;
use Romchik38\Site1\Domain\User\VO\Username;

class UserRegisterService
{

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

    /** @throws InvalidArgumentException on bad request data 
     *  @throws UsernameAlreadyInUseException 
     *  @throws CouldNotRegisterException incorrect data can be showed to user
     */
    public function register(Register $command): Id
    {
        $username = new Username($command->username);
        $isAvailable = $this->checkAvailableUsername($username);

        if ($isAvailable === false) {
            throw new UsernameAlreadyInUseException(sprintf(
                'Username %s already in use',
                $command->username
            ));
        }

        $password = new Password($command->password);
        $firstName = new Firstname($command->firstname);
        $lastName = new Firstname($command->lastname);
        $email = new Email($command->email);

        /** @var UserModelInterface $newUser */
        $newUser = $this->userRepository->create();

        /** @todo remove userRegisterDTO */
        //$providedUserData = $userRegisterDTO->getAllData();

        try {
            $newUser
                ->setUserName($username())
                ->setPassword($password())
                ->setFirstName($firstName())
                ->setLastName($lastName())
                ->SetEmail($email());

            /** @var UserModelInterface $savedUser */
            $savedUser = $this->userRepository->add($newUser);
        } catch (CouldNotSaveException $e) {
            $this->logger->log(
                sprintf('Error while registering new user: %s'),
                $e->getMessage()
            );
            throw new CouldNotRegisterException('Error while registering new user');
        }

        return new Id($savedUser->getId());
    }
}
