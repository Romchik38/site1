<?php

declare(strict_types=1);

use Romchik38\Site1\Api\Models\DTO\Main\MainDTOInterface;

return function(MainDTOInterface $data) {
    $page = $data->getPage();
    $content = $page->getContent();
    $name = htmlentities($page->getName());
    $html = <<<HTML
    <div class="row">
        <article>
            <h1 class="text-center">{$name}</h1>
            <div class="container">
                {$content}
            </div>
        </article>
    </div>
    HTML;
    return $html;
};