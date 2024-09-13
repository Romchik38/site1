<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\GoogleReCaptcha;

use Romchik38\Site1\Api\Models\DTO\ReCaptcha\ReCaptchaDTOInterface;

interface GoogleReCaptchaDTOInterface extends ReCaptchaDTOInterface
{
    const SITE_KEY_FIELD = 'site_key';
    const SECRET_KEY_FIELD = 'secret_key';
    const API_KEY_FIELD = 'api_key';
    const PROJECT_NAME_FIELD = 'project_name';
    const TYPE = 'type';
    const ENTERPRISE_TYPE = 'enterprise';
    const NON_ENTERPRISE_TYPE = 'non_enterprise';

    public function getScore(): float;
    public function getSiteKey(): string;
    public function getSecretKey(): string;
    public function getProjectName(): string;
    public function getApiKey(): string;
}
