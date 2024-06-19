<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Login;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Api\Services\SessionInterface;

class Index implements ControllerInterface
{
    public function __construct(
        protected ViewInterface $view,
        protected SessionInterface $session
    ) {
    }
    public function execute($action): string
    {
        $this->view
            ->setMetadata(ViewInterface::TITLE, 'Login Page')
            ->setControllerData('Login page content');

        return $this->view->toString();
    }
}
