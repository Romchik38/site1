<?php

declare(strict_types=1);

use \Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use \Romchik38\Site1\Api\Services\RequestInterface;

return function(LoginDTOInterface $data){

    $userName = RequestInterface::USERNAME_FIELD;
    $password = RequestInterface::PASSWORD_FIELD;
    $firstName = RequestInterface::FIRST_NAME_FIELD;
    $lastName = RequestInterface::LAST_NAME_FIELD;
    $email = RequestInterface::EMAIL_FIELD;

    $user = $data->getUser();

    $message = htmlentities($data->getMessage()) ?? '';

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
                        <input id="input-username" class="form-control" type="text" name="{$userName}" required placeholder="Enter username" pattern="[A-Za-z0-9_]{3,20}$" title="Please enter a valid username"/>
                        <div id="usernameHelpBlock" class="form-text">Username must be 3-20 characters long, cat contain lowercase, uppercase letter, number and underscore</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="{$password}">Password: </label>
                    <div class="col-sm-10">
                        <input id="input-password" class="form-control" type="password" name="{$password}" required placeholder="Enter a password" pattern="^(?=.*[_`$%^*'])(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[A-Za-z0-9_`$%^*']{8,}$" title="Please enter a valid password"/>
                        <div id="passwordHelpBlock" class="form-text">Password must be at least 8 characters long, contain at least one lowercase, uppercase letter, number and a specal character from _`$%^*'</div>
                    </div>  
                    <label class="col-sm-2 form-label" for="repeat_password">Repeat password: </label>
                    <div class="col-sm-10">
                        <input id="input-repeat-password" class="form-control" type="password" name="repeat_password" required placeholder="Repeat password"/><br>
                    </div>                  
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="{$firstName}">First name: </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="{$firstName}" id="{$firstName}" required placeholder="Enter your name" maxlength="30" pattern="^[\p{L}]{3,30}$" title="Please enter a valid first name. Use only letters"/><br>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="{$lastName}">Last name: </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="{$lastName}" id="{$lastName}" required placeholder="Enter last name" maxlength="30" pattern="^[\p{L}]{3,30}$" title="Please enter a valid first name. Use only letters"/><br>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="{$email}">Email: </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="email" name="{$email}" id="{$email}" required title="Please enter a valid email address" placeholder="Enter email"/><br>
                    </div>
                </div>
                <button id="register-button" class="btn btn-primary" type="submit">Register</button>
                </fieldset>
            </form>
            <br>
            <p id="error_button" class="error_message"><p>
            <p class="col">Already have an account? <a href="/login/index">Log In</a><p>
            <script src="/media/js/login/register/checkForm.js" defer></script>
        HTML;
    } else {
        if ($message === '') {
            $html = 
            <<<HTML
            <div>
                <form action="/auth/logout" method="post">You already signed in. Please
                    <input type="submit" value="Log out"/> first
                </form>
            </div>
            HTML;
        } else {
            $html = 
            <<<HTML
            <div>
                <p>You successfully registered and already signed in.</p>
                <ul>Please visit:
                    <li><a href="/">Main page</a> to start using our site.</li>
                    <li><a href="/login/index">Login page</a> to see your registration info</li>
                </ul>
                <form action="/auth/logout" method="post">Or you can log out now
                    <input type="submit" value="Log out"/>
                </form>
            </div>
            HTML;
        }

    }

    return $html;
};