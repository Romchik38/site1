<?php

declare(strict_types=1);

namespace Romchik38\Server\Routers;

use Romchik38\Server\Api\Router;
use Romchik38\Server\Api\RouterResult;
use Romchik38\Server\Api\Controller;
use Romchik38\Container;

class DefaultRouter implements Router
{
    protected array $controllers = [];
    protected Controller | null $notFoundController = null;

    public function __construct(
        protected RouterResult $routerResult,
        array $controllers,
        protected Container $container
    ) {
        $this->controllers[$this::REQUEST_METHOD_GET] = [];
        $this->controllers[$this::REQUEST_METHOD_POST] = [];

        foreach ($controllers as [$method, $url, $controller]) {
            $this->addController($method, $url, $controller);
        }
    }

    public function addController(
        string $method,
        string $url,
        string $controller
    ): DefaultRouter {
        $controllersByMethod = $this->controllers[$method];
        $controllersByMethod[$url] = $controller;
        $this->controllers[$method] = $controllersByMethod;
        return $this;
    }

    public function addNotFoundController()
    {
    }

    public function execute(): RouterResult
    {
        // 1. method check 
        $method = $_SERVER['REQUEST_METHOD'];
        if (array_key_exists($method, $this->controllers) === false) {
            $this->routerResult->setResponse('Method Not Allowed');
            $this->routerResult->setStatusCode(405);
            $this->routerResult->setHeaders([
                ['Allow:' . implode(', ', array_keys($this->controllers))]
            ]);
            return $this->routerResult;
        }

        // parse url
        $requestUrl = $_SERVER['REQUEST_URI'];
        [$url] = explode('?', $requestUrl);
        $dirName = pathinfo($url)['dirname'];
        $baseName = pathinfo($url)['basename'];

        // 2. Redirect from /route/basename/ to /route/basename
        if ($baseName !== '' && str_ends_with($url, '/')) {
            $redirectUrl = substr($requestUrl, 0, strlen($requestUrl) - 1);
            $this->routerResult->setHeaders([
                ['Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' 
                . $_SERVER['HTTP_HOST'] . $redirectUrl
                , true, 301]
            ]);
            $this->routerResult->setResponse('');
            $this->routerResult->setStatusCode(301);
            return $this->routerResult;
        }

        // 3. looking for exact url - / , redirect or static page 
        $controllersByMethod = $this->controllers[$_SERVER['REQUEST_METHOD']];
        $controllerClassName = '';
        if (array_key_exists($url, $controllersByMethod) === true) {
            $controllerClassName = $controllersByMethod[$url];
        } else if (array_key_exists($dirName, $controllersByMethod) === true) {
            // 4. looking for exact route
            $controllerClassName = $controllersByMethod[$dirName];
        } else if ($this->notFoundController !== null) {
            // 5. Any maches 
            // 5.1 check for 404 page
            $controllerClassName = $this->notFoundController;
        }
        // Execute Controller       
        if ($controllerClassName !== '') {
            $controller = $this->container->get($controllerClassName);
            $controllerResult = $controller->execute();
            $this->routerResult
                ->setResponse($controllerResult->getResponse())
                ->setStatusCode($controllerResult->getStatusCode())
                ->setHeaders($controllerResult->getHeaders());
            return $this->routerResult;
        }
        // 5.2 404 not found, so send default result
        $this->routerResult->setStatusCode(404)
            ->setResponse('Error 404 - Page not found');
        return $this->routerResult;
    }

}
