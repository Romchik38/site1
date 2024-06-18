<?php

declare(strict_types=1);

use Romchik38\Server\Api\Views\ViewInterface;

return function(array $data = []){
    
    if (!isset($data[ViewInterface::NAV_DATA])) {
        return '';
    }
    
    $menu = $data[ViewInterface::NAV_DATA];

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