<?php

declare(strict_types=1);

namespace Romchik38\Server\Routers;

use \Romchik38\Server\Api\Router;
use Romchik38\Server\Results\DefaultRouterResult;

class DefaultRouter implements Router
{
    public function __construct(
        protected DefaultRouterResult $routerResult
    ) {
    }

    public function execute()
    {
        return $this->routerResult;
    }
}
