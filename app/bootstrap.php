<?php

declare(strict_types=1);

use Romchik38\Container;

$container = new Container();
$container->add('resp', 'hello');

return $container;