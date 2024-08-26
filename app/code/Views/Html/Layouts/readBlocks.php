<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Layouts;


return function (string $path){
    $files = [];
    $handle = opendir($path);
    while (false !== ($entry = readdir($handle))) {
        if (is_file($path . '/' . $entry)){
            $base = pathinfo($entry)['filename'];
            $files[$base] = require($path . '/' . $entry);
        }
    }
    closedir($handle);
    return $files;
};