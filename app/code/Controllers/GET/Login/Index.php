<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\GET\Login;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Results\ControllerResultInterface;
use Romchik38\Site1\Views\Main\Index as View;

class Index implements ControllerInterface
{
    public function __construct(
        protected ControllerResultInterface $controllerResult,
        protected View $view
    ) {
    }
    public function execute($action): ControllerResultInterface
    {

        $this->view
            ->setMetadata(View::TITLE, 'Login Page')
            ->setControllerData('Login page content');
        $this->controllerResult->setResponse($this->view->toString());

        return $this->controllerResult;
    }
}
