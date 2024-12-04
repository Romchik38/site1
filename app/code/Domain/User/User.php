<?php

declare(strict_types=1);

namespace Romchik38\Site1\Domain\User;

use Romchik38\Server\Models\Model;
use Romchik38\Site1\Domain\User\UserModelInterface;

class User extends Model implements UserModelInterface
{

    public function getActive(): bool
    {
        return $this->getData(UserModelInterface::ACTIVE_FIELD);
    }

    public function getEmail(): string
    {
        return $this->getData(UserModelInterface::EMAIL_FIELD);
    }

    public function getFirstName(): string
    {
        return $this->getData(UserModelInterface::FIRST_NAME_FIELD);
    }

    public function getId(): int
    {
        return (int)$this->getData(UserModelInterface::USER_ID_FIELD);
    }

    public function getLastName(): string
    {
        return $this->getData(UserModelInterface::LAST_NAME_FIELD);
    }

    public function getPassword(): string
    {
        return $this->getData(UserModelInterface::PASSWORD_FIELD);
    }

    public function getUserName(): string
    {
        return $this->getData(UserModelInterface::USER_NAME_FIELD);
    }

    public function setActive(bool $active): UserModelInterface
    {
        $this->setData(UserModelInterface::ACTIVE_FIELD, $active);
        return $this;
    }

    public function SetEmail(string $email): UserModelInterface
    {
        $this->setData(UserModelInterface::EMAIL_FIELD, $email);
        return $this;
    }

    public function setFirstName(string $firstName): UserModelInterface
    {
        $this->setData(UserModelInterface::FIRST_NAME_FIELD, $firstName);
        return $this;
    }

    public function setId(int $id): UserModelInterface
    {
        $this->setData(UserModelInterface::USER_ID_FIELD, $id);
        return $this;
    }

    public function setLastName(string $lastName): UserModelInterface
    {
        $this->setData(UserModelInterface::LAST_NAME_FIELD, $lastName);
        return $this;
    }

    public function setPassword(string $password): UserModelInterface
    {
        $this->setData(UserModelInterface::PASSWORD_FIELD, $password);
        return $this;
    }

    public function setUserName(string $userName): UserModelInterface
    {
        $this->setData(UserModelInterface::USER_NAME_FIELD, $userName);
        return $this;
    }

}
