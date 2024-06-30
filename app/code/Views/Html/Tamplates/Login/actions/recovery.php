<?php

declare(strict_types=1);

use \Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use \Romchik38\Site1\Api\Services\RequestInterface;

return function(LoginDTOInterface $data){
    $user = $data->getUser();
    $html = '';

    $email = RequestInterface::EMAIL_FIELD;
    $emailPattern = RequestInterface::EMAIL_PATTERN;
    $emailErrorMessage = RequestInterface::EMAIL_ERROR_MESSAGE;

    if ($user === null) {
        $html = 
        <<<HTML
        <div class="container my-3">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Password recovery section</h2>
                    <p>Please, provide email address. We send a message to your with recovery link (confirm for 10 minutes).</p>
                    <p>Have a questions? Contact <a href="#">User Service</a> 24/7</p>
                </div>
                <div class="col-sm-6">
                    <form action="/auth/recovery" method="post">
                        <input class="form-control" type="email" name="{$email}" id="{$email}" required title="Please enter a valid email address" placeholder="Enter email" pattern="{$emailPattern}"/>
                        <div id="emailHelpBlock" class="form-text">Input your email</div>
                        <br>
                        <button class="btn btn-primary" type="submit">Reset</button>
                    </form>
                </div>
            </div>
        </div>
        HTML;
    }

    return $html;
};