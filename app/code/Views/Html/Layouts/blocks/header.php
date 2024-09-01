<?php

declare(strict_types=1);

use Romchik38\Server\Api\Views\Http\HttpViewInterface;
use Romchik38\Site1\Api\Models\DTO\Header\HeaderDTOInterface;

return function (array $data = []) {
    if (!isset($data[HttpViewInterface::HEADER_DATA])) {
        return '';
    }

    /** @var HeaderDTOInterface $headerData */
    $headerData = $data[HttpViewInterface::HEADER_DATA];
    $addressText = htmlentities($headerData->getAddressText());
    $phoneNumberText = htmlentities($headerData->getPhoneNumberText());
    $notice = htmlentities($headerData->getNotice());


    return <<<HEADER
        <header class="row d-none d-sm-flex my-3 mt-0">
            <div class="col-sm mt-3">
                <div class="text-center">
                    <span>{$addressText}</span>
                </div>
            </div>
            <div class="col-sm text-end">
                <p class="h5 mt-3">{$phoneNumberText}</p>
            </div>
            <div class="col-sm-3">
                <div class="mt-3">{$notice}</div>
            </div>
            <div class="col-sm-3">
                <div class="mt-3 text-center">
                    <div class="header-user-notloggedin">
                        <a class="link-notloggedin" href="/login/index">Login</a>
                        <span class="px-2">|</span>
                        <a class="link-notloggedin-create" href="/login/register">Register</a>
                    </div>
                    <div class="header-user-loggedin justify-content-center">
                        <span>Hello,&nbsp</span><a href="/login/index"><span class="user-name-field me-3">User_name</span></a>
                        <form action="/auth/logout" method="post">
                            <button class="btn btn-light py-0 align-top px-1" type="submit">Log out</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>
    HEADER;
};
