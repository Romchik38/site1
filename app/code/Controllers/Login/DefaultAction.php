<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Login;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use \Romchik38\Site1\Api\Services\SessionInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\Action;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOFactoryInterface;
use Romchik38\Site1\Domain\User\UserRepositoryInterface;
use Romchik38\Server\Api\Services\Request\Http\ServerRequestInterface;
use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;

class DefaultAction extends Action implements DefaultActionInterface
{

    public function __construct(
        protected ViewInterface $view,
        protected SessionInterface $session,
        protected LoginDTOFactoryInterface $loginDtoFactory,
        protected ServerRequestInterface $request,
        protected UserRepositoryInterface $userRepository
    ) {}
    public function execute(): string
    {
        $action = 'all';

        try {
            $user = $this->userRepository->getById($this->session->getUserId());
        } catch (NoSuchEntityException) {
            $user = null;
        }

        $message = Message::fromRequest($this->request->getQueryParams());

        /** @var LoginDTOInterface $loginDTO */
        $loginDTO = $this->loginDtoFactory->create(
            $action,
            $message(),
            $user,
            'Login',
            'Login page'
        );

        $this->view->setController($this->getController())
            ->setControllerData($loginDTO);
        return $this->view->toString();
    }
}
