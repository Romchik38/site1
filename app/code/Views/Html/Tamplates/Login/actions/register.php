<?php

declare(strict_types=1);

use \Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use \Romchik38\Site1\Api\Services\RequestInterface;

return function(LoginDTOInterface $data){

    $userName = RequestInterface::USERNAME_FIELD;
    $userNameErrorMessage = RequestInterface::USERNAME_ERROR_MESSAGE;
    $userNamePattern = RequestInterface::USERNAME_PATTERN;
    $password = RequestInterface::PASSWORD_FIELD;
    $passwordErrorMessage = RequestInterface::PASSWORD_ERROR_MESSAGE;
    $passwordPattern = RequestInterface::PASSWORD_PATTERN;
    $firstName = RequestInterface::FIRST_NAME_FIELD;
    $firstNameErrorMessage = RequestInterface::FIRST_NAME_ERROR_MESSAGE;
    $firstNamePattern = RequestInterface::FIRST_NAME_PATTERN;
    $lastName = RequestInterface::LAST_NAME_FIELD;
    $lastNameErrorMessage = RequestInterface::LAST_NAME_ERROR_MESSAGE;
    $lastNamePattern = RequestInterface::LAST_NAME_PATTERN;
    $email = RequestInterface::EMAIL_FIELD;
    $emailPattern = RequestInterface::EMAIL_PATTERN;
    $emailErrorMessage = RequestInterface::EMAIL_ERROR_MESSAGE;

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
                        <input id="input-username" class="form-control" type="text" name="{$userName}" required placeholder="Enter username" pattern="{$userNamePattern}" title="Please enter a valid username"/>
                        <div id="usernameHelpBlock" class="form-text">{$userNameErrorMessage}</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="{$password}">Password: </label>
                    <div class="col-sm-10">
                        <input id="input-password" class="form-control" type="password" name="{$password}" required placeholder="Enter a password" pattern="{$passwordPattern}" title="Please enter a valid password"/>
                        <div id="passwordHelpBlock" class="form-text">{$passwordErrorMessage}</div>
                    </div>  
                    <label class="col-sm-2 form-label" for="repeat_password">Repeat password: </label>
                    <div class="col-sm-10">
                        <input id="input-repeat-password" class="form-control" type="password" name="repeat_password" required placeholder="Repeat password"/>
                    </div>                  
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="{$firstName}">First name: </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="{$firstName}" id="{$firstName}" required placeholder="Enter your name" maxlength="30" pattern="{$firstNamePattern}" title="Please enter a valid first name. Use only letters"/>
                        <div id="emailHelpBlock" class="form-text">{$firstNameErrorMessage}</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="{$lastName}">Last name: </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="{$lastName}" id="{$lastName}" required placeholder="Enter last name" maxlength="30" pattern="{$lastNamePattern}" title="Please enter a valid first name. Use only letters"/>
                        <div id="emailHelpBlock" class="form-text">{$lastNameErrorMessage}</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 form-label" for="{$email}">Email: </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="email" name="{$email}" id="{$email}" required title="Please enter a valid email address" placeholder="Enter email" pattern="{$emailPattern}"/>
                        <div id="emailHelpBlock" class="form-text">{$emailErrorMessage}</div>
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