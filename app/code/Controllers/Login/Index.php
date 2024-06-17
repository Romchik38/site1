<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Login;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Site1\Views\Html\Classes\Main\Index as View;

class Index implements ControllerInterface
{
    public function __construct(
        protected View $view
    ) {
    }
    public function execute($action): string
    {

        $this->view
            ->setMetadata(View::TITLE, 'Login Page')
            ->setControllerData('Login page content');

        return $this->view->toString();
    }
}
