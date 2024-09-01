<?php

declare(strict_types=1);

use \Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;
use \Romchik38\Site1\Api\Services\RequestInterface;
use Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailInterface;

return function(LoginDTOInterface $data){
    $user = $data->getUser();
    $html = '';
    $h1Html = 'Password recovery page';

    $email = RequestInterface::EMAIL_FIELD;
    $emailPattern = RequestInterface::EMAIL_PATTERN;
    $emailErrorMessage = RequestInterface::EMAIL_ERROR_MESSAGE;
    $valid = RecoveryEmailInterface::VALID_TIME / 60;

    $message = $data->getMessage();
    $messageHtml = htmlentities($message);

    if ($user === null) {
        $htmlInputEmail = '';
        if ($message === '') {
            $htmlInputEmail = <<<HTML
            <div class="col-sm-6">
                <!-- <h2>Password recovery section</h2> -->
                <p>Please, provide email address. We send a message to your with recovery link (confirm for {$valid} minutes).</p>
                <p>Have a question? Contact <a href="#">User Service</a> 24/7</p>
            </div>
            <div class="col-sm-6">
                <form class="border rounded-3 p-4" action="/auth/recovery" method="post">
                    <input class="form-control" type="email" name="{$email}" id="{$email}" required title="Please enter a valid email address" placeholder="Enter email" pattern="{$emailPattern}"/>
                    <div id="emailHelpBlock" class="form-text">Input your email</div>
                    <br>
                    <button class="btn btn-secondary" type="submit">Reset</button>
                </form>
            </div>
            HTML;
        } else {
            $htmlInputEmail = <<<HTML
            <div class="col-sm-6">
                <p>Your request was sent. If you have any questions, please contact <a href="#">User Service</a> 24/7.</p>
                <p>Click on this <a href="/login/recovery">link</a> to send recovery request again.</p>
            </div>
            HTML;
        }
        $html = $html . 
        <<<HTML
        <div class="container mt-3">
            <h1 class="text-center">{$h1Html}</h1>
            <p class="lead">Forgot your password? It's not a problem.</p>
            <div class="row">
                <p class="fs-4 error_message text-center">{$messageHtml}</p>
            </div>
            <div class="row">{$htmlInputEmail}</div>
        </div>
        HTML;
    } else {
        $html = $html .
        <<<HTML
        <div class="container my-3">
            <div class="row">
                <h1 class="text-center">{$h1Html}</h1>
                <p class="lead">You already signed in. Please logout first, if you want to recovery a password.</p>
                <form action="/auth/logout" method="post">Please push the <button class="btn btn-secondary" type="submit">Log out</button> now and start a recovery process.    
                </form>
                <div class="col-sm-6 mt-4">
                    <p class="h5">Do not want to recover a password?</p>
                    <ul class="list-group"> Please visit:
                        <li class="list-group-item"><a href="/">Main page</a> to start using our site.</li>
                        <li class="list-group-item"><a href="/login/index">Login page</a> to see your registration info</li>
                        <li class="list-group-item"><a href="/sitemap">Sitemap</a> to see all our pages at the time</li>
                    </ul>
                </div>
            </div>
        </div>
        HTML;
    }

    return $html;
};