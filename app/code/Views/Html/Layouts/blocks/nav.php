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
        $active = $value['active'] ?? '';
        $menuItem = "<li class=\"nav-item\"><a class=\"nav-link {$active}\" href=\"{$value['url']}\" alt=\"{$value['alt']}\">{$value['name']}</a></li>"; 
        $menuHtml = $menuHtml . $menuItem;
    }

    return <<<NAV
       <nav class="navbar navbar-expand-sm navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="/media/img/logo-192x192.png" alt="Logo Site1" height="50">
                    Site1
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
                    <ul class="navbar-nav ">
                        {$menuHtml}
                    </ul>

                </div>

            </div>
        </nav>
    NAV;
};