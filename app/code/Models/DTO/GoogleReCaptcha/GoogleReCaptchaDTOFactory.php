<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO\GoogleReCaptcha;

use Romchik38\Site1\Api\Models\DTO\GoogleReCaptcha\GoogleReCaptchaDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\GoogleReCaptcha\GoogleReCaptchaDTOInterface;

class GoogleReCaptchaDTOFactory implements GoogleReCaptchaDTOFactoryInterface
{
    public function create(
        string $actionName,
        bool $active,
        float $score,
        string $siteKey,
        string $secretKey,
        string $projectName
    ): GoogleReCaptchaDTOInterface {
        return new GoogleReCaptchaDTO(
            $actionName,
            $active,
            $score,
            $siteKey,
            $secretKey,
            $projectName
        );
    }
}
