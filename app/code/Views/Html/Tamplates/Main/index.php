<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Tamplates\Main;

use Romchik38\Site1\Api\Models\DTO\Main\MainDTOInterface;

return function(MainDTOInterface $data) {
    $page = $data->getPage();

    /** @var $content html for the page's body*/
    $contentHtml = $page->content;
    $nameHtml = htmlentities($page->name);
    $html = <<<HTML
    <div class="row">
        <article>
            <h1 class="text-center">{$nameHtml}</h1>
            <div class="container">
                {$contentHtml}
            </div>
        </article>
    </div>
    HTML;
    return $html;
};