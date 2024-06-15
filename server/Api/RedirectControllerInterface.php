<?php

declare(strict_types=1);

namespace Romchik38\Server\Api;

interface RedirectControllerInterface extends ControllerInterface
{
    public function isRedirect(): bool;
}
