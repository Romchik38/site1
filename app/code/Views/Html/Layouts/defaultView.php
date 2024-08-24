<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Layouts;

use Romchik38\Server\Api\Views\Http\HttpViewInterface;

return function (
    array $metaData,
    string $data,
    string $wrapperName = HttpViewInterface::DEFAULT_WRAPPER
) {
    // load wrapper
    $wrapper = require_once(__DIR__ . '/wrappers/' . $wrapperName . '.php');
    
    // getting blocks
    $blocks = readBlocks(__DIR__ . '/blocks');
    
    // creating inner Html
    $wrapperHtml = $wrapper($blocks, $metaData, $data);

    // define local vars
    $title = $metaData[HttpViewInterface::TITLE] ?? '';
    $description = $metaData[HttpViewInterface::DESCRIPTION] ?? '';
    // creating html
    return <<<HTML
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="/media/css/bootstrap.min.css" rel="stylesheet">
            <link href="/media/css/main.css" rel="stylesheet">
            <title>{$title}</title>
            <meta name="description" content="{$description}">
        </head>
        <body>
            {$wrapperHtml}
            <script src="/media/js/popper.min.js"></script>
            <script src="/media/js/bootstrap.min.js"></script>
            <script src="/media/js/header/userinfo.js"></script>
        </body>
    </html>
    HTML;
};

/**
 * returns an array of filename => function(){}
 */
function readBlocks(string $path){
    $files = [];
    $handle = opendir($path);
    while (false !== ($entry = readdir($handle))) {
        if (is_file($path . '/' . $entry)){
            $base = pathinfo($entry)['filename'];
            $files[$base] = require_once($path . '/' . $entry);
        }
    }
    closedir($handle);
    return $files;
}
