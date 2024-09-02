<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Tamplates\Login;

use \Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use \Romchik38\Site1\Api\Services\RequestInterface;

return function(LoginDTOInterface $data){
    $passwordHTML = htmlentities(RequestInterface::PASSWORD_FIELD);
    $passwordErrorMessageHtml = htmlentities(RequestInterface::PASSWORD_ERROR_MESSAGE);
    $passwordPatternHtml = htmlentities(RequestInterface::PASSWORD_PATTERN);

    $messageHtml = htmlentities($data->getMessage()) ?? '';

    $html = '';
    $h1Text = 'Change password page';
    $user = $data->getUser();
    // Visitor is a guest
    if ($user === null) {
        $html = <<<HTML
            <div class="container">
                <div class="row">
                        <h1 class="text-center">{$h1Text}</h1>
                        <p class="error_message">{$messageHtml}<p>
                        <p class="lead">Only registered user can change a password. This process starts with getting a recovery link. Please, visit our <a href="/login/recovery">Recovery page</a> and follow the given instructions.</p>
                        <p>You do not forget you password? Visit <a href="/login/index">Login page</a></p>
                </div>
            </div>
        HTML;
        // Auth user
    } else {
        $html = <<<HTML
            <div class="container">
                <div class="row justify-content-center">
                    <h1 class="text-center">{$h1Text}</h1>
                    <p class="lead">On this page you can change a password. Changes take effect immediately. If you changed the password and forgot it, visit <a href="/login/recovery" alt="Recovery password page for registered users">Recovery Password Page</a>.</p>
                    <div class="col-sm-4">
                        <h2 class="text-center">Provide New Password</h2>
                        <p class="error_message">{$messageHtml}<p>
                        <form class="border rounded-3 bg-light p-4" action="/auth/changepassword" method="post">
                            <label class="form-label" for="{$passwordHTML}">Enter new password: </label>
                            <div>
                                <input id="input-password" class="form-control" type="password" name="{$passwordHTML}" required placeholder="Enter new password" pattern="{$passwordPatternHtml }" title="Please enter new valid password"/>
                                <div id="passwordHelpBlock" class="form-text">{$passwordErrorMessageHtml}</div>
                            </div>
                            <label class="form-label mt-3" for="repeat_password">Repeat password: </label>
                            <div>
                                <input id="input-repeat-password" class="form-control" type="password" name="repeat_password" required placeholder="Repeat password"/>
                            </div>                  
                            <div class="col text-center">
                                <input id="register-button" class="btn btn-secondary mt-3" type="submit" value="Change" />
                            </div>
                            
                        </form>
                        <br>
                        <p id="error_button" class="error_message text-center"><p>
                        <p>Do not want to change the password? If so, just do nothing and visit <a href="/login/index">Login page</a> to see your user information.</p>
                        <script src="/media/js/login/register/checkForm.js" defer></script>
                    </div>
                </div>
            </div>
        HTML;
    }
    return $html;
};