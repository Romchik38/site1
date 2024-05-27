<?php

declare(strict_types=1);

namespace Romchik38\Server\Api;

use Romchik38\Server\Api\RouterResult;
use Romchik38\Server\Api\Controller;

interface Router
{
    public function addController(
        string $method,
        string $url,
        Controller $controller
    ): Router;
    public function execute(): RouterResult;
}
