<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Tamplates\Login\PageNotFound;

use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;

/**
 * This is 404 page template 
 */
return function (DefaultViewDTOInterface $data) {
    /** @var string $content text of this var must be escaped, because it is a plane message, not html*/
    $content = $data->getContent();
    $contentHtml = htmlspecialchars($content);

    $html = <<<HTML
    <div class="row">
        <article>
            <div class="container">
                <div class="row my-2 h4">
                    <h1 class="text-center">Page not found</h1>
                    <p class="bg-secondary text-white">
                        {$contentHtml}
                    </p>                    
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <ol class="mb-3 list-group">Please, visit our pages:
                            <li class="list-group-item"><a href="/">Home Page</a></li>
                            <li class="list-group-item"><a href="/about">About us</a></li>
                            <li class="list-group-item"><a href="/login">Login</a></li>
                        </ol>
                    </div>
                    <p>You can find more links on our <a href="/sitemap">Sitemap page</a>.</p>
                    <p>If you have any questions, please contact us via email: info@site1.com</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere repudiandae ea nisi rem, culpa perferendis voluptas ex iure aperiam incidunt dolor minus est harum explicabo vitae architecto voluptatum doloribus corporis!</p>
                </div>
            </div>
        </article>
    </div>
    HTML;
    return $html;
};
