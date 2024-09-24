<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Tamplates\Default;

use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;

/**
 * This is a default template 
 * can be used vith default page view
 */
return function (DefaultViewDTOInterface $data) {

    /** @var $content we do not escape, because it's alreade html */
    $description = htmlentities($data->getDescription());

    $html = <<<HTML
    <div class="row">
        <article>
            <div class="container">
                {$description}
            </div>
        </article>
    </div>
    HTML;
    return $html;
};
