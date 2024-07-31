<?php

namespace Romchik38\Site1\Api\Models\DTO\Header;

use Romchik38\Server\Api\Models\DTO\DTOInterface;

interface HeaderDTOInterface extends DTOInterface {
    const PHONE_NUMBER_TEXT = 'phone_number_text';
    const ADDRESS_TEXT = 'address_text';
    const NOTICE = 'notice';

    public function getPhoneNumberText(): string;
    public function getAddressText(): string;
    public function getNotice(): string;
}