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
        // 1. start
        session_start();
        // 2. check time
        if(isset($_SESSION[SessionInterface::SESSION_LAST_VISIT_TIME_FILED])) {

                $lastVisitTime = $_SESSION[SessionInterface::SESSION_LAST_VISIT_TIME_FILED];
                $currentTime = time();  
                if (($currentTime - $lastVisitTime) > SessionInterface::SESSION_MAX_TIME_TO_LOGOUT) {
                    $this->logout();
                    header('Location: ' . $logoutRedirect);
                    exit(0);
                } else {
                    $_SESSION[SessionInterface::SESSION_LAST_VISIT_TIME_FILED] = $currentTime;
                }

        } else {
            $_SESSION[SessionInterface::SESSION_LAST_VISIT_TIME_FILED] = time();
        }
    }

    public function getLastVisiTime(): int {
        return $_SESSION[SessionInterface::SESSION_LAST_VISIT_TIME_FILED];
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
    public function logout()
    {
            unset($_SESSION[SessionInterface::SESSION_LAST_VISIT_TIME_FILED]);
            unset($_SESSION[SessionInterface::SESSION_USER_ID_FIELD]);
            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time() - 86400, '/');
            }

            session_destroy();

    }
}
