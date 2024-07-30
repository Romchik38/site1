<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Views;

use Romchik38\Server\Api\Models\DTO\DTOInterface;

interface ViewInterface
{
    public function setControllerData(DTOInterface $data): ViewInterface;
    public function setMetadata(string $key, string $value): ViewInterface;
    public function toString(): string;
}
