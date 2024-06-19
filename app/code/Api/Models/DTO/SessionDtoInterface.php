<?php

namespace Romchik38\Site1\Api\Models\DTO;

use Romchik38\Server\Api\Models\DtoInterface;

interface SessionDtoInterface extends DtoInterface {
    public function getUserId(): int;
}