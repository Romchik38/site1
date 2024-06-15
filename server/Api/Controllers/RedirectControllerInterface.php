<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Controllers;

interface RedirectControllerInterface extends ControllerInterface
{
    public function isRedirect(): bool;
}
