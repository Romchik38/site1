<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\Virtual\GoogleReCaptcha;

interface VirtualGoogleReCaptchaModelFactoryInterface
{
    public function create(): VirtualGoogleReCaptchaModelInterface;
}
