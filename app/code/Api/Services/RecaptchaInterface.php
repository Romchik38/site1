<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Services;

use Romchik38\Server\Api\Models\DTO\DTOInterface;

interface RecaptchaInterface
{
    /**
     * Checks recaptchas by given names
     * 
     * @param string $actionName Recaptcha name
     * @return bool Return true if check passed
     */
    public function checkReCaptcha(string $actionNames): bool;

    /**
     * @throws RecaptchaException
     * @return DTOInterface[]
     */
    public function getActiveRecaptchaDTOs(array $actionNames): array;
}
