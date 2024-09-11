<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\Virtual\GoogleReCaptcha;

use Romchik38\Server\Api\Models\ModelFactoryInterface;

interface VirtualGoogleReCaptchaModelFactoryInterface extends ModelFactoryInterface
{
    public function create(): VirtualGoogleReCaptchaModelInterface;
}
