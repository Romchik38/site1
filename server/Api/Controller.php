<?php

declare(strict_types=1);

namespace Romchik38\Server\Api;

use Romchik38\Server\Api\ControllerResult;

interface Controller
{
    public function execute(): ControllerResult;
}
