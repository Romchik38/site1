<?php

declare(strict_types=1);

use Romchik38\Server\Api\Views\Http\HttpViewInterface;
use Romchik38\Site1\Api\Models\DTO\Header\HeaderDTOInterface;

return function(array $data = []){
    if (!isset($data[HttpViewInterface::HEADER_DATA])) {
        return '';
    }

    /** @var HeaderDTOInterface $headerData */
    $headerData = $data[HttpViewInterface::HEADER_DATA];
    $addressText = htmlentities($headerData->getAddressText());
    $phoneNumberText = htmlentities($headerData->getPhoneNumberText());
    $notice = htmlentities($headerData->getNotice());


    return <<<HEADER
        <header class="row d-none d-md-flex my-3 mt-0">
            <div class="col-sm mt-3">
                <div class="d-flex justify-content-center">
                    <a class="link-dark text-decoration-none" href="#" title="To Home Page">
                        <span>{$addressText}</span>
                    </a>
                </div>
            </div>
            <div class="col-sm text-end">
                <p class="h5 mt-3">{$phoneNumberText}</p>
            </div>
            <div class="col-sm-3">
                <div class="mt-3">{$notice}</div>
            </div>
        </header>
    HEADER;
};