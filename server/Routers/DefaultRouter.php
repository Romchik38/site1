<?php

declare(strict_types=1);

namespace Romchik38\Server\Routers;

use Romchik38\Server\Api\Router;
use Romchik38\Server\Results\DefaultRouterResult;
use Romchik38\Server\Api\RouterResult;

class DefaultRouter implements Router
{
    public function __construct(
        protected DefaultRouterResult $routerResult
    ) {
    }

    public function execute(): RouterResult
    {
        $this->routerResult->setResponse('<h1>Hello world!</h1>');
        return $this->routerResult;
    }
}
