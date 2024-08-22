<?php

declare(strict_types=1);

use Romchik38\Server\Api\Models\DTO\DTOInterface;

return function(DTOInterface $data) {
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