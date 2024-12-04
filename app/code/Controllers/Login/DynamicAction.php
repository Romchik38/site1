<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Login;

use Romchik38\Server\Api\Controllers\Actions\DynamicActionInterface;
use \Romchik38\Site1\Api\Services\SessionInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\Action;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOFactoryInterface;
use Romchik38\Site1\Domain\User\UserRepositoryInterface;
use Romchik38\Server\Api\Services\Request\Http\ServerRequestInterface;
use Romchik38\Server\Controllers\Errors\ActionNotFoundException;
use Romchik38\Server\Controllers\Errors\DynamicActionLogicException;
use Romchik38\Server\Models\DTO\DynamicRoute\DynamicRouteDTO;
use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use Romchik38\Site1\Api\Models\DTO\ReCaptcha\ReCaptchaDTOInterface;
use Romchik38\Site1\Api\Services\RecaptchaInterface;

final class DynamicAction extends Action implements DynamicActionInterface
{
    private array $methods = [
        'index' => 'Login page',
        'register' => 'Register page',
        'recovery' => 'Password recovery page',
        'changepassword' => 'Change password page'
    ];

    public function __construct(
        protected readonly ViewInterface $view,
        protected readonly SessionInterface $session,
        protected readonly LoginDTOFactoryInterface $loginDtoFactory,
        protected readonly ServerRequestInterface $request,
        protected readonly UserRepositoryInterface $userRepository,
        protected readonly RecaptchaInterface $recaptchaService,
        protected array $recaptchas = []
    ) {}
    public function execute(string $action): string
    {
        /** 0. Check if dynamic action is repesent */
        $routes = array_keys($this->methods);
        if (array_search($action, $routes) === false) {
            throw new ActionNotFoundException(
                sprintf('Sorry, requested resource %s not found', $action)
            );
        }

        /** 1. Get user identity for DTO */
        try {
            $user = $this->userRepository->getById($this->session->getUserId());
        } catch (NoSuchEntityException) {
            $user = null;
        }

        /** 2. Get recaptchas for DTO */
        $recaptchaNames = $this->recaptchas[$action] ?? [];
        $reCaptchaHash = [];
        if (count($recaptchaNames) > 0) {
            $reCaptchaDTOs = $this->recaptchaService->getActiveRecaptchaDTOs($recaptchaNames);
            /** @var ReCaptchaDTOInterface $reCaptchaDTO */
            foreach ($reCaptchaDTOs as $reCaptchaDTO) {
                $reCaptchaHash[$reCaptchaDTO->getActionName()] = $reCaptchaDTO;
            }
        }

        $message = Message::fromRequest($this->request->getQueryParams());
        /** 
         * 3. Create a view's dto
         * @var LoginDTOInterface $loginDTO 
         * */
        $loginDTO = $this->loginDtoFactory->create(
            $action,
            $message(),
            $user,
            'Login - ' . $action,
            'Login page - ' . $action,
            $reCaptchaHash
        );

        /** 4. Exec view */
        return $this->view
            ->setController($this->getController(), $action)
            ->setControllerData($loginDTO)
            ->toString();
    }

    public function getDynamicRoutes(): array
    {
        $routes = [];
        foreach ($this->methods as $name => $description) {
            $routes[] = new DynamicRouteDTO($name, $description);
        }
        return $routes;
    }

    public function getDescription(string $dynamicRoute): string
    {
        $description = $this->methods[$dynamicRoute] ?? null;
        if (is_null($description)) {
            throw new DynamicActionLogicException(
                sprintf('Route %s not found', $dynamicRoute)
            );
        }
        return $description;
    }
}
