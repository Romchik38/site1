<?php

declare(strict_types=1);

use Romchik38\Server\Api\Views\Http\HttpViewInterface;
use Romchik38\Site1\Models\DTO\Nav\NavDTO;
use Romchik38\Site1\Api\Models\DTO\Breadcrumb\BreadcrumbDTOInterface;

return function (array $data = []) {

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

    $navBreadcumb = '';

    /** @var BreadcrumbDTOInterface $breadcrumbDTO */
    $breadcrumbDTO = $data[HttpViewInterface::BREADCRUMB_DATA] ?? null;

    if ($breadcrumbDTO !== null) {

        $stop = false;
        $currentDTO = $breadcrumbDTO;
        $line = [];
        $withouLink = 0;
        while($stop === false) {
            $stop = true;
            $name = $currentDTO->getName();
            $description = $currentDTO->getDescription();
            $url = $currentDTO->getUrl();
            $currentDTO = $currentDTO->getPrev();
            if ( $currentDTO !== null) {
                $stop = false;

            } 
            if ($withouLink === 0) {
                $withouLink++;
                array_unshift(
                    $line, 
                    '<li class="breadcrumb-item active" aria-current="page">' . $name .'</li>');
            } else {
                array_unshift(
                    $line, 
                    '<li class="breadcrumb-item"><a href="' . $url 
                        . '" title="' . $description . '">' . $name .'</a></li>');
            }
        }

        $lineHTML = implode('', $line);
        $navBreadcumb = <<<BREADCUMB
        <div class="container">
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                {$lineHTML}
            </ol>
            </nav>
        </div>
        BREADCUMB;
    }

    return <<<NAV
       <nav class="navbar navbar-expand-sm navbar-primary bg-light">
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
        {$navBreadcumb}
    NAV;
};
