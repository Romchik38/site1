<?php

declare(strict_types=1);

namespace Romchik38\Server\Api;

use Romchik38\Server\Api\RouterResult;

interface Router
{
    public function execute(): RouterResult;
}
