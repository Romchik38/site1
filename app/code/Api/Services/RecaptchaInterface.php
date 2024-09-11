<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Services;

use Romchik38\Server\Api\Models\DTO\DTOInterface;

interface RecaptchaInterface
{
    public function check(string $actionName): bool;

    /**
     * @throws RecaptchaException
     */
    public function getActiveRecaptchaDTO(string $actionName): DTOInterface;
}
