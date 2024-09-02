<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Layouts;

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
                    '<li class="breadcrumb-item active" aria-current="page">' . htmlentities($name) . '</li>'
                );
                $activeUrl = $url;
            } else {
                array_unshift(
                    $line,
                    '<li class="breadcrumb-item"><a href="' . htmlentities($url)
                        . '" title="' . htmlentities($description) . '">' . htmlentities($name) . '</a></li>'
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
                $childMenuItemHtml = '<li class="nav-item"><a class="nav-link ' . htmlentities($active) 
                    . ' text-dark" href="' . htmlentities($childUrl) . '" alt="' 
                    . htmlentities($childDescription) . '">' . htmlentities($childName) . '</a></li>';
                $childrenHtml .= $childMenuItemHtml;
            }
            $aTag = '<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">' . htmlentities($name) . '</a>';
            $menuItemHtml = '<li class="nav-item dropdown">' . $aTag . '<ul class="dropdown-menu bg-light border-primary ps-2 ps-md-0">' . $childrenHtml . '</ul></li>';
        } else {
            /** @todo implement active */
            $active = '';
            if ($activeUrl === $url) {
                $active = 'active';
            }
            $menuItemHtml = '<li class="nav-item"><a class="nav-link ' . htmlentities($active) . '" href="' . htmlentities($url) . '" alt="' . htmlentities($description) . '">' . htmlentities($name) . '</a></li>';
        }


        $menuHtml = $menuHtml . $menuItemHtml;
    }

    return <<<NAV
       <nav class="navbar navbar-expand-sm bg-primary navbar-dark">
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
                    <ul class="navbar-nav">
                        {$menuHtml}
                    </ul>
                    <div class="row d-sm-none my-3 ms-3 text-white-50">
                        <div class="header-user-notloggedin">
                            <a class="link-notloggedin text-white-50" href="/login/index">Login</a>
                            <span class="px-2">|</span>
                            <a class="link-notloggedin-create text-white-50" href="/login/register">Register</a>
                        </div>
                        <div class="header-user-loggedin justify-content-center text-white-50">
                            <span>Hello,&nbsp</span><a class="text-white-50" href="/login/index"><span class="user-name-field me-3">User_name</span></a>
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
