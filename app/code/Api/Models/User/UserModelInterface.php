<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\User;

use Romchik38\Server\Api\Models\ModelInterface;

interface UserModelInterface extends ModelInterface {
    const USER_ID_FIELD = 'user_id';
    const USER_NAME_FIELD = 'user_name';
    const FIRST_NAME_FIELD = 'first_name';
    const LAST_NAME_FIELD = 'last_name';
    const PASSWORD_FIELD = 'password';
    const ACTIVE_FIELD = 'active';

    public function getId(): int;
    public function getUserName(): string;
    public function getFirstName(): string;
    public function getLastName(): string;
    public function getPassword(): string;
    public function getactive(): bool;

    public function setId(int $id): UserModelInterface;
    public function setUserName(string $userName): UserModelInterface;
    public function setFirstName(string $firstName): UserModelInterface;
    public function setLastName(string $lastName): UserModelInterface;
    public function setPassword(string $password): UserModelInterface;
    public function setactive(bool $active): UserModelInterface;
}