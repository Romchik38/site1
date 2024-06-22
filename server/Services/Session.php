<?php

declare(strict_types=1);

namespace Romchik38\Server\Services;

use \Romchik38\Server\Api\Services\SessionInterface;

class Session implements SessionInterface
{

    // htmlentities($_SESSION['name'])
    // session_regenerate_id() 
    // and redirect the user to another page or reload the same one.

    public function __construct()
    {
        session_start();
    }

    public function getUserId(): int
    {
        return $_SESSION[SessionInterface::SESSION_USER_ID_FIELD] ?? 0;
    }

    public function logout()
    {
        unset($_SESSION[SessionInterface::SESSION_USER_ID_FIELD]);
        $_SESSION = [];
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - SessionInterface::SESSION_MAX_TIME_TO_LOGOUT, '/');
        }
        session_destroy();
    }

    public function setUserId(int $id): void
    {
        $_SESSION[SessionInterface::SESSION_USER_ID_FIELD] = $id;
    }
}
