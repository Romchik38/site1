<?php

namespace Romchik38\Site1\Models\DTO;

use Romchik38\Site1\Api\Models\DTO\LoginDtoInterface;
use Romchik38\Server\Models\Model;
use Romchik38\Server\Api\Services\SessionInterface;

class LoginDto extends Model implements LoginDtoInterface {
    public function getUserId(): int {
        return $this->getData(SessionInterface::SESSION_USER_ID_FIELD);
    }

    public function setUserId(int $userId): void {
        $this->setData(SessionInterface::SESSION_USER_ID_FIELD, $userId);
    }
}