<?php

declare(strict_types=1);

namespace Romchik38\Server\Routers;

use Romchik38\Server\Api\Router;
use Romchik38\Server\Api\RouterResult;
use Romchik38\Server\Api\Controller;

class DefaultRouter implements Router
{
    protected array $controllers = [];

    public function __construct(
        protected RouterResult $routerResult
    ) {     
        $this->controllers[$this::REQUEST_METHOD_GET] = [];
        $this->controllers[$this::REQUEST_METHOD_POST] = [];
    }

    public function addController(
        string $method,
        string $url,
        Controller $controller
    ): DefaultRouter{
        $controllersByMethod = $this->controllers[$method];
        $controllersByMethod[$url] = $controller;
        return $this;
    }

    public function execute(): RouterResult
    {
        // method check 
        $method = $_SERVER['REQUEST_METHOD'];
        if (array_key_exists($method, $this->controllers) === false) {
            $this->routerResult->setResponse('Method Not Allowed');
            $this->routerResult->setStatusCode(405);
            $this->routerResult->setHeaders([
                ['Allow:' . implode(', ', array_keys($this->controllers))]
            ]);
            return $this->routerResult;
        } 

        [$url] = explode('?', $_SERVER['REQUEST_URI']);

        // looking for exact url - / , redirect or static page 
        $controllersByMethod = $this->controllers[$_SERVER['REQUEST_METHOD']];
        if (array_key_exists($url, $controllersByMethod) === true) {
            $controller = $controllersByMethod[$url];
            return $controller->execute();
        };

        // looking for exact route
        // ...
        // ...

        // Any maches 
        // check for 404 page
        // ...
        // ...

        // 404 not found, so send default result
        return $this->routerResult;
    }

}
