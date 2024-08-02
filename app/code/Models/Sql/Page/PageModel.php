<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\Page;

use Romchik38\Server\Models\Model;
use Romchik38\Site1\Api\Models\Page\PageModelInterface;

class PageModel extends Model implements PageModelInterface
{

    public function getContent(): string
    {
        return $this->getData($this::PAGE_CONTENT_FIELD);
    }
    public function getId(): int
    {
        return (int)$this->getData($this::PAGE_ID_FIELD);
    }
    public function getName(): string
    {
        return $this->getData($this::PAGE_NAME_FIELD);
    }
    public function getUrl(): string
    {
        return $this->getData($this::PAGE_URL_FIELD);
    }
}
