<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers;

use Romchik38\Site1\Controllers\GET\Main\Index;
use Romchik38\Server\Results\DefaultControllerResult;

$controllerResult = new DefaultControllerResult();

return [
    ['GET', '/', new Index($controllerResult)]
];