<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\User;

use Romchik38\Site1\Api\Models\User\UserModelInterface;
use Romchik38\Server\Models\Model;

class User extends Model implements UserModelInterface
{
    public function getId(): int
    {
        return $this->getData(UserModelInterface::USER_ID_FIELD);
    }

    public function getUserName(): string
    {
        return $this->getData(UserModelInterface::USER_NAME_FIELD);
    }

    public function getFirstName(): string
    {
        return $this->getData(UserModelInterface::FIRST_NAME_FIELD);
    }

    public function getLastName(): string
    {
        return $this->getData(UserModelInterface::LAST_NAME_FIELD);
    }

    public function getPassword(): string
    {
        return $this->getData(UserModelInterface::PASSWORD_FIELD);
    }

    public function getactive(): bool
    {
        return $this->getData(UserModelInterface::ACTIVE_FIELD);
    }

    public function setId(int $id): UserModelInterface
    {
        $this->setData(UserModelInterface::USER_ID_FIELD, $id);
        return $this;
    }

    public function setUserName(string $userName): UserModelInterface
    {
        $this->setData(UserModelInterface::USER_NAME_FIELD, $userName);
        return $this;
    }

    public function setFirstName(string $firstName): UserModelInterface
    {
        $this->setData(UserModelInterface::FIRST_NAME_FIELD, $firstName);
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

    public function setactive(bool $active): UserModelInterface
    {
        $this->setData(UserModelInterface::ACTIVE_FIELD, $active);
        return $this;
    }
}
