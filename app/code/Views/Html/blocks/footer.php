<?php

declare(strict_types=1);

use Romchik38\Server\Api\View;

return function(array $data = []){

    if (!isset($data[View::FOOTER_DATA])) {
        return '';
    }
    
    $footerData = $data[View::FOOTER_DATA];

    $copyrights = $footerData['copyrights'];

    return <<<FOOTER
    <footer class="main">
        <div class="copyrights">{$copyrights}</div>
    </footer>
    FOOTER;
};