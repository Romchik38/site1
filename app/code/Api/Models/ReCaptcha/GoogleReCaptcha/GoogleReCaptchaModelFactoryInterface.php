<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\ReCaptcha\GoogleReCaptcha;

use Romchik38\Site1\Api\Models\ReCaptcha\ReCaptchaModelFactoryInterface;

interface GoogleReCaptchaModelFactoryInterface extends ReCaptchaModelFactoryInterface
{
    public function create(): GoogleReCaptchaModelInterface;
}
