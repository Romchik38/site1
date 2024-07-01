<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models;

interface EntityModelInterface {
    const TYPE_INT = 'int';
    const TYPE_STRING = 'string';
    const TYPE_FLOAT = 'float';

    public function getAllData(): array;
    public function getId(): int;
    public function getName(): string;
}