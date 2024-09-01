<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Tamplates\Login;

use \Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;

return function (LoginDTOInterface $data) {

    $html = <<<HTML
    <div class="container">
        <div class="row">
            <h1 class="text-center">All Login Pages</h1>
            <p>Use the links below 👇 to navigate through the login pages of our site.</p>
            <div class="col">
                <p><span class=""><a href="/login/index" target="_self">Login page</a></span> - use to log in to the website.</p>
                <p><span class=""><a href="/login/register" target="_self">Register</a></span> - for new user. Click, fill out the form, and become a smart buyer who spends money with maximum profit.</p>
                <p><span class=""><a href="/login/recovery" target="_self">Password Recovery</a></span> - quick password update.</p>
                <p><span class=""><a href="/login/changepassword" target="_self">Change password page</a></span> - use if your password was compromised.</p>
            </div>
        </div>
    </div>
    HTML;
    return $html;
};