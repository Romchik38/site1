<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO;

use Romchik38\Server\Api\Models\DTO\DTOInterface;

interface UserRegisterDTOInterface extends DTOInterface {

    public function getUserName(): string;
    public function getPassword(): string;
    public function getFirstName(): string;
    public function getLastName(): string;
    public function getEmail(): string;
    
}