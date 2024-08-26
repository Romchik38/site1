<?php

declare(strict_types=1);

use Romchik38\Site1\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;

/**
 * This is 404 page template 
 */
return function (DefaultViewDTOInterface $data) {
    $content = $data->getContent();

    $html = <<<HTML
    <div class="row">
        <article>
            <div class="container">
                <div class="row mb-3 h4">
                    {$content}
                </div>
                <div class="row">
                    <ol class="mb-3">Please, visit our pages
                        <li><a href="/">Home Page</a></li>
                        <li><a href="/about">About us</a></li>
                        <li><a href="/login">Login</a></li>
                    </ol>
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
