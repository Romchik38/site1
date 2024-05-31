<?php

declare(strict_types=1);

namespace Romchik38\Server\Api;

interface View
{
    /**
     * Metadata fields
     */
    const TITLE = 'title';

    public function setControllerData(string $data): View;
    public function setMetadata(string $key, string $value): View;
    public function toString(): string;
}
