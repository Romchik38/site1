<?php

declare(strict_types=1);

namespace Romchik38\Server\Routers;

use Romchik38\Server\Api\RouterInterface;
use Romchik38\Server\Api\Results\RouterResultInterface;
use Romchik38\Server\Api\Results\ResultInterface;
use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Services\RedirectInterface;
use Romchik38\Container;
use Romchik38\Server\Controllers\Errors\NotFoundException;

class DefaultRouter implements RouterInterface
{
    protected array $controllers = [];

    public function __construct(
        protected RouterResultInterface $routerResult,
        array $controllers,
        protected Container $container,
        protected ControllerInterface | null $notFoundController = null,
        protected RedirectInterface|null $redirectService = null

    ) {
        $this->controllers[$this::REQUEST_METHOD_GET] = [];
        $this->controllers[$this::REQUEST_METHOD_POST] = [];

        foreach ($controllers as [$method, $url, $controller, $callback]) {
            $this->addController($method, $url, $controller, $callback);
        }
    }

    public function addController(
        string $method,
        string $url,
        string $controller,
        callable|null $callback
    ): DefaultRouter {
        $controllersByMethod = $this->controllers[$method];
        $controllersByMethod[$url] = [$controller, $callback];
        $this->controllers[$method] = $controllersByMethod;
        return $this;
    }

    public function execute(): ResultInterface
    {
        // 1. method check 
        $method = $_SERVER['REQUEST_METHOD'];
        if (array_key_exists($method, $this->controllers) === false) {
            $this->routerResult->setResponse('Method Not Allowed')
                ->setStatusCode(405)
                ->setHeaders([
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
            return $this->routerResult
                ->setHeaders([
                    [
                        'Location: ' . $_SERVER['REQUEST_SCHEME'] . '://'
                            . $_SERVER['HTTP_HOST'] . $redirectUrl, true, 301
                    ]
                ])
                ->setStatusCode(301);
        }

        // 3. looking for exact url - / , redirect or static page 
        if ($this->redirectService !== null) {
            $this->redirectService->execute($url);
            if ($this->redirectService->isRedirect() === true) {
                return $this->routerResult
                    ->setHeaders([
                        [
                            $this->redirectService->getRedirectLocation(),
                            true,
                            $this->redirectService->getStatusCode()
                        ]
                    ]);
            }
        }

        // 4. Routes
        $controllersByMethod = $this->controllers[$_SERVER['REQUEST_METHOD']];
        $controllerClassName = '';
        $callback = null;
        // 4.1 looking for exact routes
        if (array_key_exists($dirName, $controllersByMethod) === true) {
            [$controllerClassName, $callback] = $controllersByMethod[$dirName];
        } else if ($this->notFoundController !== null) {
            // 5. Any maches 
            // 5.1 check for 404 page
            [$controllerClassName, $callback] = $this->notFoundController;
        }
        // Execute Controller       
        if ($controllerClassName !== '') {
            /** @var ControllerInterface $controller */
            $controller = $this->container->get($controllerClassName);
            $statusCode = ResultInterface::DEFAULT_STATUS_CODE;
            $response = ResultInterface::DEFAULT_RESPONSE;
            try {
                $response = $controller->execute($baseName);
                $statusCode = 200;
            } catch (NotFoundException $e) {
                $statusCode = 404;
                $response = htmlentities($e->getMessage());
            } // we do not catch \Exception because it catched on the server level
            $this->routerResult->setStatusCode($statusCode)
                    ->setResponse($response);
            // pass result to callback to set custom headers        
            if (is_callable($callback)) {
                $callback($this->routerResult);
            }
            return $this->routerResult;
        }
        // 5.2 404 not found, so send default result
        $this->routerResult->setStatusCode(404)
            ->setResponse('Error 404 from router - Page not found');
        return $this->routerResult;
    }
}
