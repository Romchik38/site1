<?php

declare(strict_types=1);

use \Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use \Romchik38\Server\Api\Services\RequestInterface;

return function(LoginDTOInterface $data){

    $userName = RequestInterface::USERNAME_FIELD;
    $password = RequestInterface::PASSWORD_FIELD;
    $message = $data->getMessage() ?? '';

    $html = '';
    $user = $data->getUser();
    // Visitor is a guest
    if ($user === null) {
        $html = <<<HTML
        <h2>Provide Login Credentials</h2>
        <p class="error_message">{$message}<p>
        <form action="/auth/index" method="post">
            <label for="{$userName}">Enter your user name: </label>
            <input class="form-control" type="text" name="{$userName}" id="{$userName}" required /><br>
            <label for="{$password}">Enter {$password}: </label>
            <input class="form-control" type="password" name="{$password}" id="{$password}" required /><br>
            <input class="btn btn-primary" type="submit" value="Log In" />
        </form>
        <p>Or visit <a href="/login/register">Registration Page</a></p>
        HTML;
    } else {
        $userFirstName = htmlentities($user->getFirstName());
        $userLastName = htmlentities($user->getLastName());
        $userName = htmlentities($user->getUserName());
        $userEmail = htmlentities($user->getEmail());
    // Visitor is registered user
        $html = <<<HTML
        <h2> {$userFirstName} {$userLastName} </h2>
        <p class="error_message">{$message}<p>
        <table class="table">
            <thead>
                <td>Field</td>
                <td>Information</td>
            </thead>
            <tr>
                <td>User name</td>
                <td>{$userName}</td>
            </tr>
            <tr>
                <td>First name</td>
                <td>{$userFirstName}</td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td>{$userLastName}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{$userEmail}</td>
            </tr>
        </table>
        <form action="/auth/logout" method="post">
            <input type="submit" value="Log out"/>
        </form>
        HTML;
    }
    return $html;
};