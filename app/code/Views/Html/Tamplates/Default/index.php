<?php

declare(strict_types=1);

use Romchik38\Site1\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;

return function(DefaultViewDTOInterface $data) {
    $content = $data->getContent();

    $html = <<<HTML
    <div class="row">
        <article>
            <div class="container">
                {$content}
            </div>
        </article>
    </div>
    HTML;
    return $html;
};