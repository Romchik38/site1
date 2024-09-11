<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\ReCaptcha;

use Romchik38\Server\Api\Models\ModelInterface;

interface ReCaptchaModelInterface extends ModelInterface
{
    const ACTION_NAME_FIELD = 'action';
    const ACTIVE_FIELD = 'active';

    public function getActionName(): string;
    public function getActive(): bool;

    public function setActionName(string $actionName): ReCaptchaModelInterface;
    public function setActive(bool $active): ReCaptchaModelInterface;
}
