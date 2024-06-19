<?php

namespace Romchik38\Site1\Api\Models\DTO;

use Romchik38\Server\Api\Models\DtoInterface;

interface LoginDtoInterface extends DtoInterface {
    public function getUserId(): int;

    public function setUserId(int $userId): void;
}