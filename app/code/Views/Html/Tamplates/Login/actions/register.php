<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Tamplates\Login;

use \Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use \Romchik38\Site1\Api\Services\RequestInterface;

return function(LoginDTOInterface $data){

    $userNameHtml = htmlspecialchars(RequestInterface::USERNAME_FIELD);
    $userNameErrorMessageHtml = htmlspecialchars(RequestInterface::USERNAME_ERROR_MESSAGE);
    $userNamePatternHtml = htmlspecialchars(RequestInterface::USERNAME_PATTERN);
    $passwordHtml = htmlspecialchars(RequestInterface::PASSWORD_FIELD);
    $passwordErrorMessageHtml = htmlspecialchars(RequestInterface::PASSWORD_ERROR_MESSAGE);
    $passwordPatternHtml = htmlspecialchars(RequestInterface::PASSWORD_PATTERN);
    $firstNameHtml = htmlspecialchars(RequestInterface::FIRST_NAME_FIELD);
    $firstNameErrorMessageHtml = htmlspecialchars(RequestInterface::FIRST_NAME_ERROR_MESSAGE);
    $firstNamePatternHtml = htmlspecialchars(RequestInterface::FIRST_NAME_PATTERN);
    $lastNameHtml = htmlspecialchars(RequestInterface::LAST_NAME_FIELD);
    $lastNameErrorMessageHtml = htmlspecialchars(RequestInterface::LAST_NAME_ERROR_MESSAGE);
    $lastNamePatternHtml = htmlspecialchars(RequestInterface::LAST_NAME_PATTERN);
    $emailHtml = htmlspecialchars(RequestInterface::EMAIL_FIELD);
    $emailPatternHtml = htmlspecialchars(RequestInterface::EMAIL_PATTERN);
    $emailErrorMessageHtml = htmlspecialchars(RequestInterface::EMAIL_ERROR_MESSAGE);

    $user = $data->getUser();

    $messageHtml = htmlentities($data->getMessage()) ?? '';

    $htmlBody = '';

    if ($user === null) {
        $htmlBody = <<<HTML
        <div class="col-sm-6">
            <h2>Enter User Information</h2>
            <p class="error_message">{$messageHtml}<p>
            <form class="border rounded-3 bg-light p-4" action="/auth/register" method="post">
                <fieldset>
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="{$userNameHtml}">User name: </label>
                        <div class="col-sm-10">
                            <input id="input-username" class="form-control" type="text" name="{$userNameHtml}" required placeholder="Enter username" pattern="{$userNamePatternHtml}" title="Please enter a valid username"/>
                            <div id="usernameHelpBlock" class="form-text">{$userNameErrorMessageHtml}</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="{$passwordHtml}">Password: </label>
                        <div class="col-sm-10">
                            <input id="input-password" class="form-control" type="password" name="{$passwordHtml}" required placeholder="Enter a password" pattern="{$passwordPatternHtml}" title="Please enter a valid password"/>
                            <div id="passwordHelpBlock" class="form-text">{$passwordErrorMessageHtml}</div>
                        </div>  
                        <label class="col-sm-2 form-label" for="repeat_password">Repeat password: </label>
                        <div class="col-sm-10">
                            <input id="input-repeat-password" class="form-control" type="password" name="repeat_password" required placeholder="Repeat password"/>
                        </div>                  
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="{$firstNameHtml}">First name: </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="{$firstNameHtml}" id="{$firstNameHtml}" required placeholder="Enter your name" maxlength="30" pattern="{$firstNamePatternHtml}" title="Please enter a valid first name. Use only letters"/>
                            <div id="emailHelpBlock" class="form-text">{$firstNameErrorMessageHtml}</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="{$lastNameHtml}">Last name: </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="{$lastNameHtml}" id="{$lastNameHtml}" required placeholder="Enter last name" maxlength="30" pattern="{$lastNamePatternHtml}" title="Please enter a valid first name. Use only letters"/>
                            <div id="emailHelpBlock" class="form-text">{$lastNameErrorMessageHtml}</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 form-label" for="{$emailHtml}">Email: </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="email" name="{$emailHtml}" id="{$emailHtml}" required title="Please enter a valid email address" placeholder="Enter email" pattern="{$emailPatternHtml}"/>
                            <div id="emailHelpBlock" class="form-text">{$emailErrorMessageHtml}</div>
                        </div>
                    </div>
                    <button id="register-button" class="btn btn-secondary" type="submit">Register</button>
                </fieldset>
                    </form>
                    <br>
                    <p id="error_button" class="error_message"><p>
                    <p class="col">Already have an account? <a href="/login/index">Log In</a><p>
                    <script src="/media/js/login/register/checkForm.js" defer></script>
                </div>
                <div class="col-sm-6">
                    <h2>Special offer for new users</h2>
                    <p class="my-3">After success registration, please log in to the website.</p>
                    <p class="my-3">Then buy any product and get one time <span class="bg-danger text-white px-1">discount -10%</span> on next purchase. You must use the discount withing 1 year before it expires.</p>
                    <p>Hurry up. The offer is valid for one month.</p>
                </div>
        HTML;
    } else {
        if ($messageHtml === '') {
            $htmlBody = <<<HTML
            <div class="col my-3">
                <form action="/auth/logout" method="post">
                    <span>You already signed in. Please</span>
                    <button class="btn btn-secondary" type="submit">Log out</button>
                    <span>first</span>
                </form>
            </div>
            HTML;
        } else {
            $htmlBody = <<<HTML
            <h2>You successfully registered and already signed in.</h2>
            <div class="col-sm-6 mt-4">
                    <ul class="list-group"> To start using the site, please visit:
                        <li class="list-group-item"><a href="/">Main page</a> - news and important information.</li>
                        <li class="list-group-item"><a href="/login/index">Login page</a> to see your registration info</li>
                        <li class="list-group-item"><a href="/sitemap">Sitemap</a> to see all our pages at the time</li>
                    </ul>
            </div>
            <form class="mt-3" action="/auth/logout" method="post">You can <button class="btn btn-secondary" type="submit">Log out</button> if you want to continue as a guest.
            </form>
            HTML;
        }

    }

    $html = <<<HTML
    <div class="container">
        <h1 class="text-center mb-3">Registration page for new users</h1>
        <p class="lead mb-3">Registered users have access to the special offers. They also can visit additional pages.</p>
        <div class="row">
            {$htmlBody}
        </div>
    </div>
    HTML;
    return $html;
};