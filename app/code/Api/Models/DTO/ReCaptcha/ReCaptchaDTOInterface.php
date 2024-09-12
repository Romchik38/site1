<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\ReCaptcha;

use Romchik38\Server\Api\Models\DTO\DTOInterface;

interface ReCaptchaDTOInterface extends DTOInterface
{
    public function getActionName(): string;
    public function getActive(): string;
}
