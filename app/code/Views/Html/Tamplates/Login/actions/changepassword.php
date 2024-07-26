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
                    <div class="col-sm-4">
                        <p class="error_message">{$message}<p>
                        <p>On this page you can change a password. This process starts with getting a recovery link. Please, visit our <a href="/login/recovery">Recovery page</a> and follow the given instructions.</p>
                        <p>You do not forget you password? Visit <a href="/login/index">Login page</a></p>
                    </div>
                </div>
            </div>
        HTML;
        // Auth user
    } else {
        $html = <<<HTML
            <div class="container mt-3">
                <div class="row">
                    <div class="col-sm-4">
                        <h2>Provide New Password</h2>
                        <p class="error_message">{$message}<p>
                        <form class="border rounded-3 bg-light p-4" action="/auth/changepassword" method="post">
                            <label class="col-sm-2 form-label" for="{$password}">Enter new password: </label>
                            <div class="col-sm-10">
                                <input id="input-password" class="form-control" type="password" name="{$password}" required placeholder="Enter new password" pattern="{$passwordPattern}" title="Please enter new valid password"/>
                                <div id="passwordHelpBlock" class="form-text">{$passwordErrorMessage}</div>
                            </div>
                            <label class="col-sm-2 form-label" for="repeat_password">Repeat password: </label>
                            <div class="col-sm-10">
                                <input id="input-repeat-password" class="form-control" type="password" name="repeat_password" required placeholder="Repeat password"/>
                            </div>                  

                            <input class="btn btn-secondary" type="submit" value="Change" />
                        </form>
                        <br>
                        <p>You do not forget you password and want to stay with them? Visit <a href="/login/index">Login page</a> to see your user information.</p>
                    </div>
                </div>
            </div>
        HTML;
    }
    return $html;
};