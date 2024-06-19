<?php

declare(strict_types=1);

namespace Romchik38\Server\Login;

use \Romchik38\Server\Api\Services\SessionInterface;

class Session implements SessionInterface
{
    protected int $userId = 0;

    // htmlentities($_SESSION['name'])
    // session_regenerate_id() 
    // and redirect the user to another page or reload the same one.

    public function __construct(string $logoutRedirect)
    {
        session_start();
    }

    public function getUserId(): int
    {
        return $this->userId;
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
}
