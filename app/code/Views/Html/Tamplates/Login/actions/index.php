<?php

declare(strict_types=1);

use \Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use \Romchik38\Site1\Api\Services\RequestInterface;

return function(LoginDTOInterface $data){

    $userName = RequestInterface::USERNAME_FIELD;
    $password = RequestInterface::PASSWORD_FIELD;
    $message = $data->getMessage() ?? '';

    $html = '';
    $user = $data->getUser();
    // Visitor is a guest
    if ($user === null) {
        $html = <<<HTML
        <div class="container mt-3">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Provide Login Credentials</h2>
                    <p class="error_message">{$message}<p>
                    <form action="/auth/index" method="post">
                        <label for="{$userName}">Enter your user name: </label>
                        <input class="form-control" type="text" name="{$userName}" id="{$userName}" required /><br>
                        <label for="{$password}">Enter {$password}: </label>
                        <input class="form-control" type="password" name="{$password}" id="{$password}" required /><br>
                        <input class="btn btn-secondary" type="submit" value="Log In" />
                    </form>
                    <br>
                    <p>Forgot a password? Use <a href="/login/recovery">Password recovery Page</a>.</p>
                    <p>New user? Please, visit <a href="/login/register">Registration Page</a>.</p>
                </div>
            </div>
        </div>
        HTML;
    } else {
        $userFirstName = htmlentities($user->getFirstName());
        $userLastName = htmlentities($user->getLastName());
        $userName = htmlentities($user->getUserName());
        $userEmail = htmlentities($user->getEmail());
    // Visitor is registered user
        $html = <<<HTML
        <div class="container mt-3">
            <div class="row">
                <div class="col-sm-6">
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
                    <div class="col my-3">
                        <form action="/auth/logout" method="post">
                            <button class="btn btn-outline-secondary" type="submit">Log out</button>
                        </form>
                    </div>
                </div>
                <div class="col-sm-6">
                    <p>
                        This is your user information. Please ensure that all information is provided correctly. If you have any questions regarding the registration data, contact the support service.
                    </p>
                    <p>
                        Your personal <span class="text-white bg-success px-2">discount - 10%</span>
                    </p>
                </div>
            </div>
        </div>
        HTML;
    }
    return $html;
};