<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Login;

use Romchik38\Server\Api\Controllers\Actions\DynamicActionInterface;
use Romchik38\Server\Api\Services\SessionInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\Action;
use Romchik38\Server\Controllers\Errors\NotFoundException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOFactoryInterface;
use Romchik38\Site1\Api\Models\User\UserRepositoryInterface;
use Romchik38\Site1\Api\Services\RequestInterface;
use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use Romchik38\Site1\Api\Services\RecaptchaInterface;
use Romchik38\Site1\Services\Errors\Recaptcha\RecaptchaException;

class DynamicAction extends Action implements DynamicActionInterface
{
    private array $methods = [
        'index',
        'register',
        'recovery',
        'changepassword'
    ];

    public function __construct(
        protected ViewInterface $view,
        protected SessionInterface $session,
        protected LoginDTOFactoryInterface $loginDtoFactory,
        protected RequestInterface $request,
        protected UserRepositoryInterface $userRepository,
        protected RecaptchaInterface $recaptchaService
    ) {}
    public function execute(string $action): string
    {

        try {
            $user = $this->userRepository->getById($this->session->getUserId());
        } catch (NoSuchEntityException) {
            $user = null;
        }

        try {
            $reCaptchaDTO = $this->recaptchaService->getActiveRecaptchaDTO();
        } catch(RecaptchaException $e) {
            $reCaptchaDTO = null;
        }

        /** @var LoginDTOInterface $loginDTO */
        $loginDTO = $this->loginDtoFactory->create(
            $action,
            $this->request->getMessage(),
            $user,
            'Login - ' . $action,
            'Login page - ' . $action
        );

        if (array_search($action, $this->methods) === false) {
            throw new NotFoundException('Sorry, requested resource ' . $action . ' not found');
        }

        $this->view->setController($this->getController(), $action)
            ->setControllerData($loginDTO);
        return $this->view->toString();
    }

    public function getRoutes(): array
    {
        return $this->methods;
    }
}
