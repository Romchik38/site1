<?php

declare(strict_types=1);

use \Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use \Romchik38\Server\Api\Services\RequestInterface;

return function(LoginDTOInterface $data){

    $userName = RequestInterface::USERNAME_FIELD;
    $password = RequestInterface::PASSWORD_FIELD;
    $message = $data->getMessage() ?? '';

    $html = '';
    if ($data->getUserId() === 0) {
        $html = <<<HTML
        <h2>Provide Login Credentials</h2>
        <p class="error_message">{$message}<p>
        <form action="/auth/index" method="post">
            <label for="{$userName}">Enter your user name: </label>
            <input type="text" name="{$userName}" id="{$userName}" required /><br>
            <label for="{$password}">Enter {$password}: </label>
            <input type="{$password}" name="{$password}" id="{$password}" required /><br>
            <input type="submit" value="Log In" />
        </form>
        <p>Or visit <a href="/login/register">Registration Page</a></p>
        HTML;
    } else {
        $html = 'Welcome User';
    }
    return $html;
};