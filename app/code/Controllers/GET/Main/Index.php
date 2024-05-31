<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\GET\Main;

use Romchik38\Server\Api\Controller;
use Romchik38\Server\Api\ControllerResult;
use Romchik38\Site1\Views\Main\Index as View;

class Index implements Controller
{
    public function __construct(
        protected ControllerResult $controllerResult,
        protected View $view
    ) {
    }
    public function execute(): ControllerResult
    {
        [$url] = explode('?', $_SERVER['REQUEST_URI']);
        $baseName = pathinfo($url)['basename'];

        if ($baseName === '') {
            $this->view->setMetadata(View::TITLE, 'Home Page')
                ->setControllerData('<h1>Home page</h1>');            
            $this->controllerResult->setResponse($this->view->toString());
        } else if ($baseName === 'about') {
            $this->view->setMetadata(View::TITLE, 'About Page')
            ->setControllerData('<h1>About page</h1>');  
            $this->controllerResult->setResponse($this->view->toString()); 
        } else {
            $this->controllerResult->setResponse('From controller - 404 Error page not found');
            $this->controllerResult->setStatusCode(404);
        }
        return $this->controllerResult;
    }
}
