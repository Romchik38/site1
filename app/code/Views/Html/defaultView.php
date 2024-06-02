<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html;

use Romchik38\Server\Api\View;


function defaultView(
    array $metaData,
    string $data,
    string $wrapperName = View::DEFAULT_WRAPPER
) {
    // load wrapper
    $wrapper = require_once(__DIR__ . '/wrappers/' . $wrapperName . '.php');
    
    // getting blocks
    $blocks = readBlocks();
    
    // creating inner Html
    $wrapperHtml = $wrapper($blocks, $metaData, $data);

    // creating html
    return <<<HTML
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="/media/css/bootstrap.min.css" rel="stylesheet">
            <link href="/media/css/main.css" rel="stylesheet">
            <title>{$metaData[View::TITLE]}</title>
        </head>
        <body>
            {$wrapperHtml}
        </body>
    </html>
    HTML;
}

/**
 * returns an array of filename => function(){}
 */
function readBlocks(){
    $files = [];
    $path = __DIR__ . '/blocks';
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
