<?php

declare(strict_types=1);

use \Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use \Romchik38\Site1\Api\Services\RequestInterface;

return function(LoginDTOInterface $data){
    $password = RequestInterface::PASSWORD_FIELD;
    $passwordErrorMessage = RequestInterface::PASSWORD_ERROR_MESSAGE;
    $passwordPattern = RequestInterface::PASSWORD_PATTERN;

    $message = $data->getMessage() ?? '';

    $html = '';
    $user = $data->getUser();
    // Visitor is a guest
    if ($user === null) {
        $html = <<<HTML
            <div class="container mt-3">
                <div class="row">
                        <p class="error_message">{$message}<p>
                        <p>User can change a password. This process starts with getting a recovery link. Please, visit our <a href="/login/recovery">Recovery page</a> and follow the given instructions.</p>
                        <p>You do not forget you password? Visit <a href="/login/index">Login page</a></p>
                </div>
            </div>
        HTML;
        // Auth user
    } else {
        $html = <<<HTML
            <div class="container mt-3">
                <div class="row justify-content-center">
                    <div class="col-sm-4">
                        <h2 class="text-center">Provide New Password</h2>
                        <p class="error_message">{$message}<p>
                        <form class="border rounded-3 bg-light p-4" action="/auth/changepassword" method="post">
                            <label class="form-label" for="{$password}">Enter new password: </label>
                            <div>
                                <input id="input-password" class="form-control" type="password" name="{$password}" required placeholder="Enter new password" pattern="{$passwordPattern}" title="Please enter new valid password"/>
                                <div id="passwordHelpBlock" class="form-text">{$passwordErrorMessage}</div>
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
                        <p>Do you remember the password? If so, just do nothing and visit <a href="/login/index">Login page</a> to see your user information.</p>
                        <script src="/media/js/login/register/checkForm.js" defer></script>
                    </div>
                </div>
            </div>
        HTML;
    }
    return $html;
};