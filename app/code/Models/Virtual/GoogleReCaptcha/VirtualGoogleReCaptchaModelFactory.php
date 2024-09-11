<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Virtual\GoogleReCaptcha;

use Romchik38\Site1\Api\Models\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelFactoryInterface;
use Romchik38\Site1\Api\Models\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelInterface;

class VirtualGoogleReCaptchaModelFactory implements VirtualGoogleReCaptchaModelFactoryInterface
{
    public function create(): VirtualGoogleReCaptchaModelInterface
    {
        return new VirtualGoogleReCaptchaModel();
    }
}
