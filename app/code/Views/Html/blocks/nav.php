<?php

declare(strict_types=1);

use Romchik38\Server\Api\View;

return function(array $data = []){
    
    if (!isset($data[View::NAV_DATA])) {
        return '';
    }
    
    $menu = $data[View::NAV_DATA];

    $menuHtml = '';
    foreach ($menu as $value) {
        $menuItem = "<li><a href=\"{$value['url']}\" alt=\"{$value['alt']}\">{$value['name']}</a></li>"; 
        $menuHtml = $menuHtml . $menuItem;
    }

    return <<<NAV
    <nav>
        <ul class="menu">
            {$menuHtml}
        </ul>
    </nav>
    NAV;
};