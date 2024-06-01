<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html;

use Romchik38\Server\Api\View;

//function defaultView(array $metaData, string $data)
function defaultView($metaData, $data)
{
    return <<<HTML
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>{$metaData[View::TITLE]}</title>
        </head>
        <body>
            {$data}
        </body>
    </html>
    HTML;
}
