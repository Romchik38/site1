<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\ReCaptcha;

use Romchik38\Server\Api\Models\ModelFactoryInterface;

interface ReCaptchaModelFactoryInterface extends ModelFactoryInterface
{
    public function create(): ReCaptchaModelInterface;
}
