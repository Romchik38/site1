<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Tamplates\Sitemap;

use Romchik38\Site1\Controllers\Sitemap\DefaultAction\SitemapDTO;

/**
 * This is a Sitemap template 
 */
return function (SitemapDTO $data) {

    $output = $data->output;

    $html = <<<HTML
    <div class="row">
        <article>
            <div class="container">
                <h1 class="text-center">Sitemap</h1>
                <p class="lead">Use this links to navigate through the site.</p>
                {$output}
            </div>
        </article>
    </div>
    HTML;
    return $html;
};