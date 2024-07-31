<?php

namespace Romchik38\Site1\Models\DTO\Header;

use Romchik38\Server\Models\DTO;
use Romchik38\Site1\Api\Models\DTO\Header\HeaderDTOInterface;

class HeaderDTO extends DTO implements HeaderDTOInterface{

    public function __construct(
        string $phoneNumberText,
        string $addressText,
        string $notice,
    )
    {
        $this->data[$this::PHONE_NUMBER_TEXT] = $phoneNumberText;
        $this->data[$this::ADDRESS_TEXT] = $addressText;
        $this->data[$this::NOTICE] = $notice;
    }

    public function getPhoneNumberText(): string {
        return $this->getData(HeaderDTOInterface::PHONE_NUMBER_TEXT);
    }

    public function getAddressText(): string {
        return $this->getData(HeaderDTOInterface::ADDRESS_TEXT);
    }

    public function getNotice(): string {
        return $this->getData(HeaderDTOInterface::NOTICE);
    }
}