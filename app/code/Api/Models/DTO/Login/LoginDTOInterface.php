<?php

namespace Romchik38\Site1\Api\Models\DTO\Login;

use Romchik38\Server\Api\Models\DTOInterface;
use Romchik38\Site1\Api\Models\DTO\ActionDTOInterface;
use Romchik38\Site1\Api\Models\User\UserModelInterface;

interface LoginDTOInterface extends DTOInterface, ActionDTOInterface {
    const USER_FIELD = 'user';

    public function getActionName(): string;
    public function getMessage(): string;
    public function getUser(): UserModelInterface|null;
    
    public function setActionName(string $action): LoginDTOInterface;
    public function setMessage(string $message): LoginDTOInterface;
    public function setUser(UserModelInterface $user): LoginDTOInterface;
}