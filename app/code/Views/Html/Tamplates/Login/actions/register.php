<?php

declare(strict_types=1);

use \Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use \Romchik38\Server\Api\Services\RequestInterface;

return function(LoginDTOInterface $data){

    $userName = RequestInterface::USERNAME_FIELD;
    $password = RequestInterface::PASSWORD_FIELD;
    $firstName = RequestInterface::FIRST_NAME_FIELD;
    $lastName = RequestInterface::LAST_NAME_FIELD;

    $user = $data->getUser();

    $message = $data->getMessage() ?? '';

    $html = '';

    if ($user === null) {
        $html = 
        <<<HTML
            <h2>Provide Login Credentials</h2>
            <p class="error_message">{$message}<p>
            <form action="/auth/register" method="post">
                <label for="{$userName}">Enter your user name: </label>
                <input type="text" name="{$userName}" id="{$userName}" required /><br>
                <label for="{$password}">Enter {$password}: </label>
                <input type="password" name="{$password}" id="{$password}" required /><br>
                <label for="repeat_password">Repeat password: </label>
                <input type="password" name="repeat_password" id="repeat_password" required /><br>
                <label for="{$firstName}">First name: </label>
                <input type="text" name="{$firstName}" id="{$firstName}" required /><br>
                <label for="{$lastName}">Last name: </label>
                <input type="text" name="{$lastName}" id="{$lastName}" required /><br>
                <input type="submit" value="Register" />
            </form>
            <p>Already have an account? <a href="/login/index">Log In</a></p>
        HTML;
    } else {
        $html = 
        <<<HTML
        <div>
            <form action="/auth/logout" method="post">You already signed in. Please
            <input type="submit" value="Log out"/> first
        </form>
        </div>
        HTML;
    }

    return $html;
};