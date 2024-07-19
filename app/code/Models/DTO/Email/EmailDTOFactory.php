<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO\Email;

use Romchik38\Site1\Api\Models\DTO\Email\EmailDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\Email\EmailDTOInterface;
use Romchik38\Site1\Models\DTO\Email\EmailDTO;

class EmailDTOFactory implements EmailDTOFactoryInterface
{

    public function create(
        string $emailAddress,
        string $subject,
        string $message,
        array $headers
    ): EmailDTOInterface {
        return new EmailDTO(
            $emailAddress,
            $subject,
            $message,
            $headers
        );
    }
}