<?php

declare(strict_types=1);

use Romchik38\Server\Api\Views\Http\HttpViewInterface;
use Romchik38\Site1\Models\DTO\Nav\NavDTO;

return function(array $data = []){
    
    if (!isset($data[HttpViewInterface::NAV_DATA])) {
        return '';
    }
    
    /** @var NavDTO $navDTO */
    $navDTO = $data[HttpViewInterface::NAV_DATA];
    $menuDTO = $navDTO->getMenuDTO();
    $links = $menuDTO->getLinks();

    $menuHtml = '';
    foreach ($links as $link) {
        $active = '';   //   << this must be implemented for  active link
        $url = $link->getUrl();
        $description = $link->getDescription();
        $name = $link->getName();
        $menuItem = "<li class=\"nav-item\"><a class=\"nav-link {$active}\" href=\"{$url}\" alt=\"{$description}\">{$name}</a></li>"; 
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