<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Romchik38\Server\TestClass;

echo '<pre>';
print_r($_SERVER);
echo '</pre>';


echo '<pre>';
print_r($_GET);
echo '</pre>';

$t1 = new TestClass();

echo $t1->hello;