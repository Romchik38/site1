<?php

namespace Romchik38\Site1\Models\DTO;

use Romchik38\Site1\Api\Models\DTO\SessionDtoInterface;
use Romchik38\Server\Models\Model;
use Romchik38\Server\Api\Services\SessionInterface;

class SessionDto extends Model implements SessionDtoInterface {
    public function getUserId(): int {
        return $this->getData(SessionInterface::SESSION_USER_ID_FIELD);
    }
}