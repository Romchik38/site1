<?php

namespace Romchik38\Site1\Api\Models\DTO\Login;

use Romchik38\Server\Api\Models\DTOInterface;
use Romchik38\Site1\Api\Models\DTO\ActionDTOInterface;

interface LoginDTOInterface extends DTOInterface, ActionDTOInterface {

    public function getActionName(): string;
    public function getUserId(): int;
    
    public function setActionName(string $action): LoginDTOInterface;
    public function setUserId(int $userId): LoginDTOInterface;
}