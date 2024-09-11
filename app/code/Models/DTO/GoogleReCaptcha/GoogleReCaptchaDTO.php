<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO\GoogleReCaptcha;

use Romchik38\Server\Models\DTO;
use Romchik38\Site1\Api\Models\DTO\GoogleReCaptcha\GoogleReCaptchaDTOInterface;
use Romchik38\Site1\Api\Models\ReCaptcha\GoogleReCaptcha\GoogleReCaptchaModelInterface;
use Romchik38\Site1\Api\Models\ReCaptcha\ReCaptchaModelInterface;

class GoogleReCaptchaDTO extends DTO implements GoogleReCaptchaDTOInterface
{

    public function __construct(
        string $actionName,
        bool $active,
        float $score,
        string $siteKey,
        string $secretKey,
        string $projectName,
        string $apiKey
    ) {
        $this->data[ReCaptchaModelInterface::ACTION_NAME_FIELD] = $actionName;
        $this->data[ReCaptchaModelInterface::ACTIVE_FIELD] = $active;
        $this->data[GoogleReCaptchaModelInterface::SCORE_FIELD] = $score;
        $this->data[GoogleReCaptchaDTOInterface::SITE_KEY_FIELD] = $siteKey;
        $this->data[GoogleReCaptchaDTOInterface::SECRET_KEY_FIELD] = $secretKey;
        $this->data[GoogleReCaptchaDTOInterface::PROJECT_NAME_FIELD] = $projectName;
        $this->data[GoogleReCaptchaDTOInterface::API_KEY_FIELD] = $apiKey;
    }

    public function getActionName(): string
    {
        return $this->data[ReCaptchaModelInterface::ACTION_NAME_FIELD];
    }

    public function getActive(): string
    {
        return $this->data[ReCaptchaModelInterface::ACTIVE_FIELD];
    }

    public function getScore(): float
    {
        return $this->data[GoogleReCaptchaModelInterface::SCORE_FIELD];
    }

    public function getSiteKey(): string
    {
        return $this->data[GoogleReCaptchaDTOInterface::SITE_KEY_FIELD];
    }

    public function getSecretKey(): string
    {
        return $this->data[GoogleReCaptchaDTOInterface::SECRET_KEY_FIELD];
    }

    public function getProjectName(): string
    {
        return $this->data[GoogleReCaptchaDTOInterface::PROJECT_NAME_FIELD];
    }

    public function getApiKey(): string
    {
        return $this->data[GoogleReCaptchaDTOInterface::API_KEY_FIELD];
    }
}
