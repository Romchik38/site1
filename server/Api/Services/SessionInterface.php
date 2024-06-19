<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Services;

use Romchik38\Server\Login\Session;

interface SessionInterface {
    const SESSION_USER_ID_FIELD = 'user_id';
    const SESSION_LAST_VISIT_TIME_FILED = 'last_visit_time';
    const SESSION_MAX_TIME_TO_LOGOUT = 86400;

    /**
     * Get time of last user visit
     * @return int
     */
    public function getLastVisiTime(): int;    

    /**
     * Get user id if it was provided
     * @return int [0 if there isn't user id]
     */
    public function getUserId(): int;
}