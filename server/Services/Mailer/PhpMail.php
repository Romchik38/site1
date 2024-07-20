<?php

namespace Romchik38\Server\Services\Mailer;

use Romchik38\Server\Api\Services\MailerInterface;

class PhpMail implements MailerInterface {
    public function send();
}