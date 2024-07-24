<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Services;

use Psr\Log\LoggerInterface;

interface LoggerServerInterface extends LoggerInterface{
    public function sendAllLogs(): void;
}