<?php

declare(strict_types=1);

namespace Romchik38\Server\Routers;

use Romchik38\Server\Api\Router;
use Romchik38\Server\Api\RouterResult;
use Romchik38\Server\Api\Controller;

class DefaultRouter implements Router
{
    public function __construct(
        protected RouterResult $routerResult
    ) {
    }

    public function addController(
        string $method,
        string $url,
        Controller $controller
    ): DefaultRouter{
        
        return $this;
    }

    public function execute(): RouterResult
    {
        $this->routerResult->setResponse('<h1>Hello world!</h1>');
        return $this->routerResult;
    }
}
