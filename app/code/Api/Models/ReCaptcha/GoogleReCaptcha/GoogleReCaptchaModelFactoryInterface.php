<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\ReCaptcha\GoogleReCaptcha;

interface GoogleReCaptchaModelFactoryInterface
{
    public function create(): GoogleReCaptchaModelInterface;
}
