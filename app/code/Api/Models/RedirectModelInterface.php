<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models;

use Romchik38\Server\Api\Models\ModelInterface;

/** @todo delete this */
interface RedirectModelInterface extends ModelInterface
{
    public function getRedirectTo(): string;
    public function getRedirectCode(): int;
}
