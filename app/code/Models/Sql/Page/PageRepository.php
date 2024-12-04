<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\Page;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Models\Sql\Repository;
use Romchik38\Site1\Domain\Page\PageModelInterface;
use Romchik38\Site1\Domain\Page\PageRepositoryInterface;

class PageRepository extends Repository implements PageRepositoryInterface
{
    public function getByUrl(string $url): PageModelInterface
    {
        /** @param array<int,PageModelInterface> $result */
        $result = $this->list(' WHERE url = $1', [$url]);
        $count = count($result);
        if ($count === 0) {
            throw new NoSuchEntityException(sprintf('Page with url %s not exist', $url));
        } elseif ($count === 1) {
            return $result[0];
        } else {
            throw new \RuntimeException(sprintf('Page with url %s has duplicate', $url));
        }
    }

    public function getUrls(string $expression = '', array $param = []): array
    {
        $query = 'SELECT ' . $this->table . '.url FROM ' . $this->table
            . $expression;
        return $this->database->queryParams($query, $param);
    }

    public function listAll(): array
    {
        return $this->list('', []);
    }
}
