<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Login;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Api\Services\SessionInterface;
use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOFactoryInterface;

class Index implements ControllerInterface
{
    public function __construct(
        protected ViewInterface $view,
        protected SessionInterface $session,
        protected LoginDTOFactoryInterface $loginDtoFactory
    ) {
    }
    public function execute($action): string
    {
        /** @var \Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface $loginDTO */
        $loginDTO = $this->loginDtoFactory->create();
        $loginDTO->setActionName($action);
        $this->view
            ->setMetadata(ViewInterface::TITLE, 'Login Page')
            ->setControllerData($loginDTO);

        return $this->view->toString();
    }
}
