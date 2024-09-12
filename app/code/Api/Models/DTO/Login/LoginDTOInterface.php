<?php

namespace Romchik38\Site1\Api\Models\DTO\Login;

use Romchik38\Server\Api\Models\DTO\DTOInterface;
use Romchik38\Site1\Api\Models\DTO\ActionDTOInterface;
use Romchik38\Site1\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;
use Romchik38\Site1\Api\Models\User\UserModelInterface;

interface LoginDTOInterface extends DTOInterface, ActionDTOInterface, DefaultViewDTOInterface
{
    const USER_FIELD = 'user';
    const RECAPTCHA_HASH_FIELD = 'recaptcha_hash';

    public function getMessage(): string;
    public function getUser(): UserModelInterface|null;
    public function getRecaptchaHash(): array;
}
