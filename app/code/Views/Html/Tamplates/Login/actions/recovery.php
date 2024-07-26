<?php

declare(strict_types=1);

use \Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use \Romchik38\Site1\Api\Services\RequestInterface;
use Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailInterface;

return function(LoginDTOInterface $data){
    $user = $data->getUser();
    $html = '';

    $email = RequestInterface::EMAIL_FIELD;
    $emailPattern = RequestInterface::EMAIL_PATTERN;
    $emailErrorMessage = RequestInterface::EMAIL_ERROR_MESSAGE;
    $valid = RecoveryEmailInterface::VALID_TIME / 60;

    $message = $data->getMessage();

    if ($user === null) {
        $html = $html . 
        <<<HTML
        <div class="container my-3">
            <div class="row">
                <p class="fs-4 error_message text-center">{$message}</p>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <h2>Password recovery section</h2>
                    <p>Please, provide email address. We send a message to your with recovery link (confirm for {$valid} minutes).</p>
                    <p>Have a question? Contact <a href="#">User Service</a> 24/7</p>
                </div>
                <div class="col-sm-6">
                    <form class="border rounded-3 bg-light p-4" action="/auth/recovery" method="post">
                        <input class="form-control" type="email" name="{$email}" id="{$email}" required title="Please enter a valid email address" placeholder="Enter email" pattern="{$emailPattern}"/>
                        <div id="emailHelpBlock" class="form-text">Input your email</div>
                        <br>
                        <button class="btn btn-primary" type="submit">Reset</button>
                    </form>
                </div>
            </div>
        </div>
        HTML;
    } else {
        $html = $html .
        <<<HTML
        <div class="container my-3">
            <div class="row">
                <h2>You already signed in.</h2>
                <ul>Please visit:
                    <li><a href="/">Main page</a> to start using our site.</li>
                    <li><a href="/login/index">Login page</a> to see your registration info</li>
                </ul>
                <form action="/auth/logout" method="post">Or you can <button class="btn btn-primary" type="submit">Log out</button> now and then start recovery process.
                    
                </form>
            </div>
        </div>
        HTML;
    }

    return $html;
};