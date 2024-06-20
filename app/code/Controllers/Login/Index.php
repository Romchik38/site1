<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Login;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Api\Services\SessionInterface;
use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use Romchik38\Server\Controllers\Errors\NotFoundException;

class Index implements ControllerInterface
{
    private array $methods = [
        'index'
    ];
    public function __construct(
        protected ViewInterface $view,
        protected SessionInterface $session,
        protected LoginDTOFactoryInterface $loginDtoFactory
    ) {
    }
    public function execute($action): string
    {
        /** @var LoginDTOInterface $loginDTO */
        $loginDTO = $this->loginDtoFactory->create();
        $loginDTO->setActionName($action);

        if (array_search($action, $this->methods) !== false) {
            $this->$action($loginDTO);
        } else {
            throw new NotFoundException('Sorry, requested resource ' . $action . ' not found');
        }
        $this->view
            ->setMetadata(ViewInterface::TITLE, 'Login Page')
            ->setControllerData($loginDTO);
        return $this->view->toString();
    }

    private function index(LoginDTOInterface $dto): void
    {
        $dto->setUserId($this->session->getUserId());
    }
}
