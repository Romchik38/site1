<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\controllersList;

use Romchik38\Site1\Controllers\GET\Main\Index;

return [
    ['GET', '/', \Romchik38\Site1\Controllers\GET\Main\Index::class],
    ['GET', '/login', \Romchik38\Site1\Controllers\GET\Login\Index::class]
];