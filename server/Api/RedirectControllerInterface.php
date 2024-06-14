<?php

declare(strict_types=1);

namespace Romchik38\Server\Api;

use Romchik38\Server\Api\ControllerResultInterface;

interface RedirectControllerInterface extends ControllerInterface
{
    public function isRedirect(): bool;
}
