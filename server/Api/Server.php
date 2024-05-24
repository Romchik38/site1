<?php

declare(strict_types=1);

namespace Romchik38\Server\Api;

use Romchik38\Container;

interface Server {
    public function __construct(Container $container);
    public function run();
}