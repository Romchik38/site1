<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Tamplates\Default;

use Romchik38\Site1\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;

/**
 * This is a default template 
 * can be used vith default page view
 */
return function (DefaultViewDTOInterface $data) {

    /** @var $content we do not escape, because it's alreade html */
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
