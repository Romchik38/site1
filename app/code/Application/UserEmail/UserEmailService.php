<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\UserEmail;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Application\UserEmail\Views\AuthDTO;
use Romchik38\Site1\Application\UserEmail\Views\RecoveryDTO;
use Romchik38\Site1\Domain\User\UserRepositoryInterface;
use Romchik38\Site1\Domain\User\VO\Email;

final class UserEmailService
{
    public function __construct(
        protected readonly UserRepositoryInterface $userRepository
    ) {}

    /**
     * @throws InvalidArgumentException
     * @throws NoSuchEmailException
     */
    public function checkEmailForRecovery(FindEmail $command): RecoveryDTO
    {
        $email = new Email($command->email);

        /* 3. Check if email is present in the database */
        try {
            $user = $this->userRepository->getByEmail($email());
        } catch (NoSuchEntityException) {
            throw new NoSuchEmailException(sprintf(
                'Email %s do not exist',
                $command->email
            ));
        }

        return new RecoveryDTO(
            $user->getEmail(),
            $user->getFirstName()
        );
    }

    public function checkEmailForAuth(FindEmail $command): AuthDTO
    {
        $email = new Email($command->email);

        /* 3. Check if email is present in the database */
        try {
            $user = $this->userRepository->getByEmail($email());
        } catch (NoSuchEntityException) {
            throw new NoSuchEmailException(sprintf(
                'Email %s do not exist',
                $command->email
            ));
        }

        return new AuthDTO(
            $user->getId(),
            $user->getEmail()
        );
    }
}
