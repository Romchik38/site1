<?php

declare(strict_types=1);

use \Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use \Romchik38\Site1\Api\Services\RequestInterface;

return function(LoginDTOInterface $data){

    $userNameHtml = htmlentities(RequestInterface::USERNAME_FIELD);
    $passwordHtml = htmlentities(RequestInterface::PASSWORD_FIELD);
    $messageHtml = htmlentities($data->getMessage()) ?? '';

    $html = '';
    $h1Html = 'Login page';
    $user = $data->getUser();
    // Visitor is a guest
    if ($user === null) {
        $html = <<<HTML
        <div class="container">
            <div class="row justify-content-center">
                <h1 class="text-center">{$h1Html}</h1>
                <p class="lead">On this page you can provide your login credentials. Please visit <a href="/login/recovery" alt="Recovery password page">Recovery password page</a> if your forgot a password. We will send a special link via email.</p>
                <p>Do not registered yet? Visit <a href="/login/register" alt="Register page">Register page</a>. Just a few minutes and you is a registered user.</p>
                <div class="col-sm-4">
                    <h2 class="text-center">Provide Login Credentials</h2>
                    <p class="error_message">{$messageHtml}<p>
                    <form class="border rounded-3 p-4" action="/auth/index" method="post">
                        <label for="{$userNameHtml}">Enter your user name: </label>
                        <input class="form-control" type="text" name="{$userNameHtml}" id="{$userNameHtml}" required /><br>
                        <label for="{$passwordHtml}">Enter {$passwordHtml}: </label>
                        <input class="form-control" type="password" name="{$passwordHtml}" id="{$passwordHtml}" required /><br>
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
        $userFirstNameHtml = htmlentities($user->getFirstName());
        $userLastNameHtml = htmlentities($user->getLastName());
        $userNameHtml = htmlentities($user->getUserName());
        $userEmailHtml = htmlentities($user->getEmail());
    // Visitor is registered user
        $html = <<<HTML
        <div class="container">
            <div class="row">
                <h1 class="text-center">{$h1Html}</h1>
                <p class="lead">On the user profile page you can see all information about you and your customer data.</p>
                <div class="col-sm-6">
                    <h2> {$userFirstNameHtml} {$userLastNameHtml} </h2>
                    <p class="error_message">{$messageHtml}<p>
                    <table class="table">
                        <thead>
                            <td>Field</td>
                            <td>Information</td>
                        </thead>
                        <tr>
                            <td>User name</td>
                            <td>{$userNameHtml}</td>
                        </tr>
                        <tr>
                            <td>First name</td>
                            <td>{$userFirstNameHtml}</td>
                        </tr>
                        <tr>
                            <td>Last Name</td>
                            <td>{$userLastNameHtml}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{$userEmailHtml}</td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td><a href="/login/changepassword">change</a></td>
                        </tr>
                    </table>
                    <div class="col my-3">
                        <form action="/auth/logout" method="post">
                            <button class="btn btn-secondary" type="submit">Log out</button>
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