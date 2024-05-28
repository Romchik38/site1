<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\GET\Main;

use Romchik38\Server\Api\Controller;
use Romchik38\Server\Api\ControllerResult;

class Index implements Controller
{
    public function __construct(
        protected ControllerResult $controllerResult
    ) {
    }
    public function execute(): ControllerResult
    {
        [$url] = explode('?', $_SERVER['REQUEST_URI']);
        $baseName = pathinfo($url)['basename'];

        if ($baseName === '') {
            $this->controllerResult->setResponse('<h1>Home page</h1>');
        } else if ($baseName === 'about') {
            $this->controllerResult->setResponse('<h1>About page</h1>');
        } else {
            $this->controllerResult->setResponse('From controller - 404 Error page not found');
            $this->controllerResult->setStatusCode(404);
        }

        return $this->controllerResult;
    }
}
