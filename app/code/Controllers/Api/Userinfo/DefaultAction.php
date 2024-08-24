<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Api\Userinfo;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Services\SessionInterface;
use Romchik38\Server\Controllers\Actions\Action;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Api\Models\User\UserModelInterface;
use Romchik38\Site1\Api\Models\User\UserRepositoryInterface;

/**
 * return info about rigistered user 
 * json format:
 * 
 * {
 *      "success": [
 *          "username": string
 *      ],
 * }
 * 
 * {
 *      "error": string
 * }
 * 
 * @api v0.0.1
 * 
 */
class DefaultAction extends Action implements DefaultActionInterface
{
    const SUCCESS_FIELD = 'success';
    const ERROR_FIELD = 'error';
    const USERNAME_FIELD = 'username';

    const MUST_BE_LOGGED_IN_ERROR = 'You must be logged in to make a request';
    const SERVER_ERROR = 'We are sorry. There are some issues on our side. Please try again later';


    protected array $data = [];
    protected array $failedResponse = [];
    protected array $successResponse = [];


    public function __construct(
        protected SessionInterface $session,
        protected UserRepositoryInterface $userRepository
    ) {}

    public function execute(): string
    {
        $data = [
            'username' => 'ser'
        ];

        $userId = $this->session->getUserId();
        if ($userId === 0) {
            return $this->createError($this::MUST_BE_LOGGED_IN_ERROR);
        }

        try {
            /** @var UserModelInterface $user */
            $user = $this->userRepository->getById($userId);
            $this->data[$this::USERNAME_FIELD] = $user->getFirstName();
            return $this->createSuccess($this->data);
        } catch (NoSuchEntityException $e) {
            return $this->createError($this::SERVER_ERROR);
        }
    }

    protected function createSuccess(array $data): string
    {
        $this->successResponse[$this::SUCCESS_FIELD] = $data;
        return json_encode($this->successResponse);
    }

    protected function createError(string $error): string
    {
        $this->failedResponse[$this::ERROR_FIELD] = $error;
        return json_encode($this->failedResponse);
    }
}
