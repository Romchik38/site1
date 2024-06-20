<?php

declare(strict_types=1);

use \Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;

return function(LoginDTOInterface $data){

    $html = '';
    if ($data->getUserId() === 0) {
        $html = <<<HTML
        <h2>Provide Login Credentials</h2>
        <form action="/login/auth" mathod="post">
            <label for="name">Enter your name: </label>
            <input type="text" name="name" id="name" required />
            <input type="password" name="password" id="password" required />
            <input type="submit" value="Log In" />
        </form>
        <p>Or visit <a href="#">Registration Page</a></p>
        HTML;
    } else {
        $html = 'Welcome User';
    }
    return $html;
};