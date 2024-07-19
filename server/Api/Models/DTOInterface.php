<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models;

interface DTOInterface 
{
    public function getData(string $key): mixed;
    public function getAllData(): array;
}
