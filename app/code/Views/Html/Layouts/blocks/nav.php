<?php

declare(strict_types=1);

use Romchik38\Server\Api\Views\Http\HttpViewInterface;
use Romchik38\Site1\Models\DTO\Nav\NavDTO;
use Romchik38\Site1\Api\Models\DTO\Breadcrumb\BreadcrumbDTOInterface;

return function (array $data = []) {

    if (!isset($data[HttpViewInterface::NAV_DATA])) {
        return '';
    }

    /**
     * shows whick link is active 
     * checke in braedcumbs
     * used in menu
     */
    $activeUrl = '';

    $navBreadcumb = '';

    /** @var BreadcrumbDTOInterface $breadcrumbDTO */
    $breadcrumbDTO = $data[HttpViewInterface::BREADCRUMB_DATA] ?? null;

    if ($breadcrumbDTO !== null) {

        $stop = false;
        $currentDTO = $breadcrumbDTO;
        $line = [];
        $withouLink = 0;
        while ($stop === false) {
            $stop = true;
            $name = $currentDTO->getName();
            $description = $currentDTO->getDescription();
            $url = $currentDTO->getUrl();
            $currentDTO = $currentDTO->getPrev();
            if ($currentDTO !== null) {
                $stop = false;
            }
            if ($withouLink === 0) {
                $withouLink++;
                array_unshift(
                    $line,
                    '<li class="breadcrumb-item active" aria-current="page">' . $name . '</li>'
                );
                $activeUrl = $url;
            } else {
                array_unshift(
                    $line,
                    '<li class="breadcrumb-item"><a href="' . $url
                        . '" title="' . $description . '">' . $name . '</a></li>'
                );
            }
        }

        $lineHTML = implode('', $line);
        $navBreadcumb = <<<BREADCUMB
        <div class="container">
            <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                {$lineHTML}
            </ul>
            </nav>
        </div>
        BREADCUMB;
    }

    /** @var NavDTO $navDTO */
    $navDTO = $data[HttpViewInterface::NAV_DATA];
    $menuDTO = $navDTO->getMenuDTO();
    $links = $menuDTO->getLinks();

    $menuHtml = '';
    foreach ($links as $link) {
        /** @todo implement active */
        $url = $link->getUrl();
        $description = $link->getDescription();
        $name = $link->getName();
        // dropdown
        $children = $link->getChildrens();
        if (count($children) > 0) {
            $childrenHtml = '';
            foreach ($children as $child) {
                $childUrl = $child->getUrl();
                $childDescription = $child->getDescription();
                $childName = $child->getName();
                /** @todo implement active */
                $active = '';
                if ($activeUrl === $childUrl) {
                    $active = 'active';
                }
                $menuItem = "<li class=\"nav-item\"><a class=\"nav-link {$active}\" href=\"{$childUrl}\" alt=\"{$childDescription}\">{$childName}</a></li>";
                $childrenHtml .= $menuItem;
            }
            $aTag = '<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">' . $name . '</a>';
            $menuItem = '<li class="nav-item dropdown">' . $aTag . '<ul class="dropdown-menu">' . $childrenHtml . '</ul></li>';
        } else {
            /** @todo implement active */
            $active = '';
            if ($activeUrl === $url) {
                $active = 'active';
            }
            $menuItem = "<li class=\"nav-item\"><a class=\"nav-link {$active}\" href=\"{$url}\" alt=\"{$description}\">{$name}</a></li>";
        }


        $menuHtml = $menuHtml . $menuItem;
    }

    return <<<NAV
       <nav class="navbar navbar-expand-sm bg-primary">
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
                    <div class="row d-sm-none my-3 ms-3">
                        <div class="header-user-notloggedin">
                            <a class="link-notloggedin" href="/login/index">Login</a>
                            <span class="px-2">|</span>
                            <a class="link-notloggedin-create" href="/login/register">Register</a>
                        </div>
                        <div class="header-user-loggedin justify-content-center">
                            <span>Hello,&nbsp</span><span class="user-name-field me-3">User_name</span>
                            <form action="/auth/logout" method="post">
                                <button class="btn btn-light py-0 align-top px-1" type="submit">Log out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        {$navBreadcumb}
    NAV;
};
