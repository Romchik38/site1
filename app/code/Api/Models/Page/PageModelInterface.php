<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\Page;

use Romchik38\Server\Api\Models\ModelInterface;

interface PageModelInterface extends ModelInterface
{
    public function getContent(): string;
    public function getId(): int;
    public function getName(): string;
    public function getUrl(): string;
}
