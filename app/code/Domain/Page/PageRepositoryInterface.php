<?php

declare(strict_types=1);

namespace Romchik38\Site1\Domain\Page;

use Romchik38\Server\Api\Models\RepositoryInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;

interface PageRepositoryInterface extends RepositoryInterface
{
    /** 
     * @throws NoSuchEntityException
     * @throws \RuntimeException on duplicate
     */
    public function getByUrl(string $url): PageModelInterface;

    /** @return array<int,PageModelInterface> */
    public function listAll(): array;
}
