<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\ReCaptcha;

interface ReCaptchaModelFactoryInterface extends ModelFactoryInterface
{
    public function create(): ReCaptchaModelInterface;
}
