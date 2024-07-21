<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Services;

use Romchik38\Server\Api\Models\DTO\Email\EmailDTOInterface;

interface MailerInterface {
    public function send(EmailDTOInterface $emailDTO): void;
}