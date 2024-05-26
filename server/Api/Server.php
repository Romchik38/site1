<?php

declare(strict_types=1);

namespace Romchik38\Server\Api;

use Romchik38\Container;

interface Server {
    const DEFAULT_SERVER_ERROR_CODE = 500;
    const DEFAULT_SERVER_ERROR_MESSAGE = 'Server 500 error. Please try later';

    public function __construct(Container $container);
    public function run();
}