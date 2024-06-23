<?php

declare(strict_types=1);

use \Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use \Romchik38\Server\Api\Services\RequestInterface;

return function(LoginDTOInterface $data){

    $userName = RequestInterface::USERNAME_FIELD;
    $password = RequestInterface::PASSWORD_FIELD;
    $firstName = RequestInterface::FIRST_NAME_FIELD;
    $lastName = RequestInterface::LAST_NAME_FIELD;
    $email = RequestInterface::EMAIL_FIELD;

    $user = $data->getUser();

    $message = $data->getMessage() ?? '';

    $html = '';

    if ($user === null) {
        $html = 
        <<<HTML
            <h2>Enter User Information</h2>
            <p class="error_message">{$message}<p>
            <form action="/auth/register" method="post">
                <fieldset>
                <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="{$userName}">User name: </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="{$userName}" id="{$userName}" required placeholder="Enter user name"/><br>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="{$password}">Password: </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="password" name="{$password}" id="{$password}" required placeholder="Enter a password" aria-describedby="passwordHelpBlock"/><br>
                        <div id="passwordHelpBlock" class="form-text">Your password must be at least 8 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.</div>
                    </div>  
                    <label class="col-sm-2 form-label" for="repeat_password">Repeat password: </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="password" name="repeat_password" id="repeat_password" required placeholder="Repeat password"/><br>
                    </div>                  
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="{$firstName}">First name: </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="{$firstName}" id="{$firstName}" required placeholder="Enter your name"/><br>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="{$lastName}">Last name: </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="{$lastName}" id="{$lastName}" required placeholder="Enter last name"/><br>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="{$email}">Email: </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="email" name="{$email}" id="{$email}" pattern="\w+@[a-zA-Z0-9]+\.[a-zA-Z]+$" required placeholder="Enter email"/><br>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Register</button>
                </fieldset>
            </form>
            <div class="container">
                <div class="row">
                    <div class="col">Already have an account? <a href="/login/index">Log In</a></div>
                </div>
            </div>
            <script src="/media/js/login/register/checkForm.js" defer></script>
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