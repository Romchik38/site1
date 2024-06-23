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
    const EMAIL_FIELD = 'email';

    public function getActive(): bool;
    public function getId(): int;
    public function getEmail(): string;
    public function getFirstName(): string;
    public function getLastName(): string;
    public function getPassword(): string;
    public function getUserName(): string;    

    public function setActive(bool $active): UserModelInterface;
    public function setId(int $id): UserModelInterface;
    public function SetEmail(string $email): UserModelInterface;
    public function setFirstName(string $firstName): UserModelInterface;
    public function setLastName(string $lastName): UserModelInterface;
    public function setPassword(string $password): UserModelInterface;
    public function setUserName(string $userName): UserModelInterface;
}