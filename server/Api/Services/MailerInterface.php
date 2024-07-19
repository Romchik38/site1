<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Services;

interface MailerInterface {
    public function send(MailDTO): void {

    }
}