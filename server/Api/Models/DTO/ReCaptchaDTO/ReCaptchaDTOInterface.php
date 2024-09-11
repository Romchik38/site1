<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\ReCaptchaDTO;

interface ReCaptchaDTOInterface {
    const ACTION_NAME_FIELD = 'action';
    
    public function getActionName(): string;
}