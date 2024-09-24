<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Services;

use Romchik38\Server\Api\Services\SessionInterface as ServicesSessionInterface;

interface SessionInterface extends ServicesSessionInterface
{
    public function getUserId(): int;
    public function setUserId(int $id): SessionInterface;
}
