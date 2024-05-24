<?php

declare(strict_types=1);

namespace Romchik38\Server;

use Romchik38\Container;

abstract class DefaultServer implements Api\Server
{
    public function __construct(
        protected Container $container
    ) {
    }

    public function run()
    {
    }
}
