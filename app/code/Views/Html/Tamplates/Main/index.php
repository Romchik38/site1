<?php

declare(strict_types=1);

/** @param Romchik38\Site1\Api\Models\PageModelInterface $data */
return function($data) {
    $content = $data->getContent();
    $name = htmlentities($data->getName());
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