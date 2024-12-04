<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Api\Userinfo;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Models\DTO\Api\ApiDTOFactoryInterface;
use Romchik38\Server\Api\Models\DTO\Api\ApiDTOInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use \Romchik38\Site1\Api\Services\SessionInterface;
use Romchik38\Server\Controllers\Actions\Action;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Domain\User\UserModelInterface;
use Romchik38\Site1\Domain\User\UserRepositoryInterface;

/**
 * return info about rigistered user 
 * see docs/api/userinfo.md
 * 
 * @api v0.0.2
 * 
 */
class DefaultAction extends Action implements DefaultActionInterface
{
    const USERNAME_FIELD = 'username';

    const MUST_BE_LOGGED_IN_ERROR = 'You must be logged in to make a request';
    const SERVER_ERROR = 'We are sorry. There are some issues on our side. Please try again later';


    protected array $data = [];
    protected string $apiName = 'User Api point';
    protected string $apiDescription = 'Check user data. Status: error/success. Result: error description/ success username ';


    public function __construct(
        protected SessionInterface $session,
        protected UserRepositoryInterface $userRepository,
        protected ApiDTOFactoryInterface $apiDTOFactory,
        protected ViewInterface $view
    ) {}

    public function execute(): string
    {
        // 1. Unauthorized request
        $userId = $this->session->getUserId();
        if ($userId === 0) {
            $apiDTO = $this->apiDTOFactory->create(
                $this->apiName,
                $this->apiDescription,
                ApiDTOInterface::STATUS_ERROR,
                $this::MUST_BE_LOGGED_IN_ERROR,
            );

            return $this->view->setControllerData($apiDTO)->toString();
        }

        try {
            // 2. Success response
            /** @var UserModelInterface $user */
            $user = $this->userRepository->getById($userId);
            $this->data[$this::USERNAME_FIELD] = $user->getFirstName();
            $apiDTO = $this->apiDTOFactory->create(
                $this->apiName,
                $this->apiDescription,
                ApiDTOInterface::STATUS_SUCCESS,
                $this->data,
            );
            return $this->view->setControllerData($apiDTO)->toString();
        } catch (NoSuchEntityException $e) {
            // 3. Error response (session exist, but user was deleted from database)
            $apiDTO = $this->apiDTOFactory->create(
                $this->apiName,
                $this->apiDescription,
                ApiDTOInterface::STATUS_ERROR,
                $this::SERVER_ERROR,
            );
            $this->session->logout();
            return $this->view->setControllerData($apiDTO)->toString();
        }
    }

    public function getDescription(): string {
        return 'User data (api endpoint)';
    }
}
