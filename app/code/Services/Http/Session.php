<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services\Http;

use Romchik38\Server\Api\Services\SessionInterface;
use Romchik38\Server\Services\Session\Http\Session as HttpSession;

class Session extends HttpSession
{
    const SESSION_USER_ID_FIELD = 'user_id';

    public function getUserId(): int
    {
        return $this->getData($this::SESSION_USER_ID_FIELD) ?? 0;
    }

    public function setUserId(int $id): SessionInterface
    {
        $this->setData($this::SESSION_USER_ID_FIELD, $id);
        return $this;
    }
}
