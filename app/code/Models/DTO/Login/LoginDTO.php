<?php

namespace Romchik38\Site1\Models\DTO\Login;

use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use Romchik38\Server\Models\Model;
use Romchik38\Server\Api\Services\SessionInterface;

class LoginDTO extends Model implements LoginDTOInterface {
    public function getActionName(): string {
        return $this->getData($this::ACTION_FIELD_NAME);
    }

    public function getUserId(): int {
        return $this->getData(SessionInterface::SESSION_USER_ID_FIELD);
    }

    public function setActionName(string $action): LoginDTOInterface
    {
        $this->setData($this::ACTION_FIELD_NAME, $action);
        return $this;
    }

    public function setUserId(int $userId): LoginDTOInterface {
        $this->setData(SessionInterface::SESSION_USER_ID_FIELD, $userId);
        return $this;
    }
}