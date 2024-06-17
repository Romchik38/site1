<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Controllers;

use Romchik38\Server\Api\Results\ControllerResultInterface;

interface ControllerInterface
{
    public function execute(string $action): string;
}
