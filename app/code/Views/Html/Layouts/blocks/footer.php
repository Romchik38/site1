<?php

declare(strict_types=1);

use Romchik38\Server\Api\Views\ViewInterface;

return function(array $data = []){

    if (!isset($data[ViewInterface::FOOTER_DATA])) {
        return '';
    }
    
    $footerData = $data[ViewInterface::FOOTER_DATA];

    $copyrights = $footerData['copyrights'];

    return <<<FOOTER
    <footer class="container border">
        <div class="copyrights">{$copyrights}</div>
    </footer>
    FOOTER;
};