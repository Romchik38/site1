<?php

declare(strict_types=1);

/** @param \Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface $data */
return function($data) {

    $action = $data->getActionName();

    $html = <<<HTML
    <article>
        <h1>Login Page</h1>
        <div class="content">
            <p>On this page, you can log in to the site and see information for authorized users.</p>
            <p>Additionally, you will see all prices with special discounts, if available.</p>
            <p>We offer many benefits to registered users, so let's register and log in if you haven't done so yet.</p>
        </div>
        <div class="action">
            {$action}
        </div>
    </article>
    HTML;
    return $html;
};