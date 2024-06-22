<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Tamplates\Login;

use \Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;

return function(LoginDTOInterface $data) {
    
    $actions = ['index'];
    $actionHtml = '';
    $action = $data->getActionName();

    if (array_search($action, $actions) !== false) {
        $fn = require_once(__DIR__ . '/actions/' . $action . '.php');
        $actionHtml = $fn($data);
    }

    $html = <<<HTML
    <article>
        <h1>Login Page</h1>
        <div class="content">
            <p>On this page, you can log in to the site and see information for authorized users. Additionally, you will see all prices with special discounts, if available.
            We offer many benefits to registered users, so let's register and log in if you haven't done so yet.</p>
        </div>
        <div class="action">
            {$actionHtml}
        </div>
    </article>
    HTML;
    return $html;
};