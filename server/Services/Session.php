<?php

declare(strict_types=1);

namespace Romchik38\Server\Login;

use \Romchik38\Server\Api\SessionInterface;

class Session implements SessionInterface
{
    protected int $visitorId = 0;

    // htmlentities($_SESSION['name'])

    // SessionInterface::SESSION_FIELD
    // $_SESSION = [];

    //   if (isset($_COOKIE[session_name()])) {
    //     setcookie(session_name(), ", time()-86400, '/');
    //   }

    // session_destroy();

    // session_regenerate_id() 
    // and redirect the user to another page or reload the same one.

    public function __construct()
    {
        session_start();
    }

    public function logout()
    {
        if (isset($_SESSION[SessionInterface::SESSION_FIELD])) {
            $this->visitorId = $_SESSION[SessionInterface::SESSION_FIELD];

            unset($_SESSION[SessionInterface::SESSION_FIELD]);
            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time() - 86400, '/');
            }

            session_destroy();
        }
    }
}
