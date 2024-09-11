<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\GoogleReCaptcha;

interface GoogleReCaptchaDTOFactoryInterface
{
    public function create(
        string $actionName,
        bool $active,
        float $score,
        string $siteKey,
        string $secretKey,
        string $projectName,
    ): GoogleReCaptchaDTOInterface;
}
