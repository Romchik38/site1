<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Tamplates\Sitemap;

use Romchik38\Server\Api\Models\DTO\Controller\ControllerDTOInterface;
use Romchik38\Site1\Api\Models\DTO\Sitemap\SitemapDTOInterface;

/**
 * This is a Sitemap template 
 */
return function (SitemapDTOInterface $data) {

    $menuLinks = $data->getMenuLinks();
    $root = $data->getRootControllerDto();

    $menuLinksHash = [];
    foreach ($menuLinks as $menuLink) {
        $menuLinksHash[$menuLink->getUrl()] = $menuLink;
    }

    $siteMaphtml = '<ul>' . createHtml($root, $menuLinksHash) . '</ul>';

    $html = <<<HTML
    <div class="row">
        <article>
            <div class="container">
                <h1 class="text-center">Sitemap</h1>
                <p class="lead">Use this links to navigate through the site.</p>
                {$siteMaphtml}
            </div>
        </article>
    </div>
    HTML;
    return $html;
};

function mapHome($arr)
{
    $newArr = [];
    foreach ($arr as $elem) {
        if ($elem === 'root') {
            $newArr[] = '';
        } else {
            $newArr[] = $elem;
        }
    }
    return $newArr;
}


function createHtml(ControllerDTOInterface $element, array $hash): string
{
    $children = $element->getChildren();
    $path = mapHome($element->getPath());
    $name = $element->getName();
    $url = $name;
    if ($name === 'root') {
        $url = '';
        $name = 'home';
    }
    $link = implode('/', $path) . '/' . $url;

    /** @var MenuLinksInterface $menuLink */
    $menuLink = $hash[$link] ?? null;
    $description = '';
    if ($menuLink !== null) {
        $name = $menuLink->getName();
        $description = $menuLink->getDescription();
    }

    if (count($children) === 0) {
        $elemName = '<a href="' . $link . '" title="' . $description . '">' . $name . '</a>';
        $lastElement = '<li>' . $elemName . '</li>';
        return $lastElement;
    }
    $rowName = '<a href="' . $link . '" title="' . $description . '">' . $name . '</a>';
    $rowElements = [];
    foreach ($children as $child) {
        $rowElem = createHtml($child, $hash);
        $rowElements[] = $rowElem;
    }

    return '<li>' . $rowName . '<ul>' . implode('', $rowElements) . '</ul></li>';
}