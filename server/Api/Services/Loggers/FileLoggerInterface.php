<?php

namespace Romchik38\Server\Api\Services\Loggers;

interface FileLoggerInterface {
    const DEFAULT_PROTOCOL = 'file://';
    const DATE_TIME_FORMAT = 'Y-m-d H:i:s';
}