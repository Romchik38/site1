<?php

declare(strict_types=1);

namespace Romchik38\Server\Controllers;

use Romchik38\Server\Api\Results\ControllerResultInterface;
use Romchik38\Server\Api\Controllers\RedirectControllerInterface;
use Romchik38\Server\Api\Models\RedirectRepositoryInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;

class Redirect implements RedirectControllerInterface
{

    protected bool $redirect = false;

    public function __construct(
        protected ControllerResultInterface $controllerResult,
        protected RedirectRepositoryInterface $redirectRepository
    ) {
    }

    public function execute($action): ControllerResultInterface
    {
        try {
            $redirectUrl = $this->redirectRepository->checkUrl($action);
            if ($redirectUrl !== '') {
                $this->redirect = true;
                $this->controllerResult
                    ->setHeaders([
                        [
                            'Location: ' . $_SERVER['REQUEST_SCHEME'] . '://'
                                . $_SERVER['HTTP_HOST']
                                . $redirectUrl->getRedirectTo(),
                            true,
                            $redirectUrl->getRedirectCode()
                        ]
                    ])
                    ->setStatusCode(301);
            }
            return $this->controllerResult;
        } catch (NoSuchEntityException $e) {
            // return empty result
            return $this->controllerResult;
        }
    }
    public function isRedirect(): bool
    {
        return $this->redirect;
    }
}
