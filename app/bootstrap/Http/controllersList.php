<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\controllersList;

return [
    ['GET', '/', \Romchik38\Site1\Controllers\Main\Index::class],
    ['GET', '/login', \Romchik38\Site1\Controllers\Login\Index::class]
];