<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\GoogleReCaptchaDTO;

use Romchik38\Server\Api\Models\DTO\DTOInterface;

interface GoogleReCaptchaDTOInterface extends DTOInterface
{

    const SITE_KEY_FIELD = 'site_key';
    const SECRET_KEY_FIELD = 'secret_key';
    const API_KEY_FIELD = 'api_key';
    const PROJECT_NAME_FIELD = 'project_name';
    const SCORE_FIELD = 'score';

    public function getSiteKey(): string;
    public function getSecretKey(): string;
    public function getApiKey(): string;
    public function getProjectName(): string;
    public function getScore(): string;
}
