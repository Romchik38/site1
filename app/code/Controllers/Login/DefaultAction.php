<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Login;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use \Romchik38\Site1\Api\Services\SessionInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractAction;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOFactoryInterface;
use Romchik38\Site1\Domain\User\UserRepositoryInterface;
use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;

final class DefaultAction extends AbstractAction implements DefaultActionInterface
{
    public function __construct(
        protected readonly ViewInterface $view,
        protected readonly SessionInterface $session,
        protected readonly LoginDTOFactoryInterface $loginDtoFactory,
        protected readonly ServerRequestInterface $request,
        protected readonly UserRepositoryInterface $userRepository
    ) {}
    public function execute(): ResponseInterface
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
        $response = new Response();
        $responseBody = $response->getBody();
        $responseBody->write($this->view->toString());
        return $response->withBody($responseBody);
    }

    public function getDescription(): string
    {
        return 'Login pages';
    }
}
