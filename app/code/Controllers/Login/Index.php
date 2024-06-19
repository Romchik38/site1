<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Login;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Api\Services\SessionInterface;
use Romchik38\Site1\Api\Models\DTO\LoginDtoFactoryInterface;

class Index implements ControllerInterface
{
    public function __construct(
        protected ViewInterface $view,
        protected SessionInterface $session,
        protected LoginDtoFactoryInterface $loginDtoFactory
    ) {
    }
    public function execute($action): string
    {
        $loginDto = $this->loginDtoFactory->create();
        
        $this->view
            ->setMetadata(ViewInterface::TITLE, 'Login Page')
            ->setControllerData($loginDto);

        return $this->view->toString();
    }
}
