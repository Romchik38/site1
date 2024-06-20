<?php

declare(strict_types=1);

use Romchik38\Site1\Api\Models\DTO\Main\MainDTOInterface;

return function(MainDTOInterface $data) {
    $page = $data->getPage();
    $content = $page->getContent();
    $name = htmlentities($page->getName());
    $html = <<<HTML
    <article>
        <h1>{$name}</h1>
        <div class="content">
            {$content}
        </div>
    </article>
    HTML;
    return $html;
};