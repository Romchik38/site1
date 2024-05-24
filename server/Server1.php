<?php

declare(strict_types=1);

namespace Romchik38\Server;

use Romchik38\Container;

class Server1 implements Api\Server
{
    public function __construct(
        private Container $container
    ) {
    }

    public function run()
    {
        echo $this->container->get('resp');
    }
}
