<?php

declare(strict_types=1);

namespace Romchik38\Server\Api;

use Romchik38\Server\Api\ControllerResultInterface;

interface ControllerInterface
{
    public function execute(): ControllerResultInterface;
}
