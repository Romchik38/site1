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
        $this->controllerResult->setResponse('<h1>Home page</h1>');
        return $this->controllerResult;
    }
}
