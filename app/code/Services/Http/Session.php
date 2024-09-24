<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services\Http;

use Romchik38\Server\Services\Session\Http\Session as ServerSession;
use Romchik38\Site1\Api\Services\SessionInterface as Site1SessionInterface;

class Session extends ServerSession implements Site1SessionInterface
{
    const SESSION_USER_ID_FIELD = 'user_id';

    public function getUserId(): int
    {
        return $this->getData($this::SESSION_USER_ID_FIELD) ?? 0;
    }

    public function setUserId(int $id): Site1SessionInterface
    {
        $this->setData($this::SESSION_USER_ID_FIELD, $id);
        return $this;
    }
}
