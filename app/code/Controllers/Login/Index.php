<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Login;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Api\Services\SessionInterface;
use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use Romchik38\Server\Controllers\Errors\NotFoundException;
use Romchik38\Site1\Api\Services\RequestInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Api\Models\User\UserRepositoryInterface;


class Index implements ControllerInterface
{
    private array $methods = [
        'index',
        'register',
        'recovery'
    ];
    
    public function __construct(
        protected ViewInterface $view,
        protected SessionInterface $session,
        protected LoginDTOFactoryInterface $loginDtoFactory,
        protected RequestInterface $request,
        protected UserRepositoryInterface $userRepository
    ) {
    }
    public function execute($action): string
    {
        /** @var LoginDTOInterface $loginDTO */
        $loginDTO = $this->loginDtoFactory->create();
        $loginDTO->setActionName($action);
        $loginDTO->setMessage($this->request->getMessage());

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
        try {
            $user = $this->userRepository->getById($this->session->getUserId());
            $dto->setUser($user);
        } catch(NoSuchEntityException) {
            // $dto->getUser will be null
        }
        
    }

    /**
     * Action /login/recovery
     *
     * @return void
     */
    public  function recovery(LoginDTOInterface $dto){
        $this->index($dto);
        return $dto;
    }

    private function register(LoginDTOInterface $dto){
        $this->index($dto);
        return $dto;
    }
}
