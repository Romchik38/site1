<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\Page;

use Romchik38\Server\Api\Models\ModelInterface;

interface PageModelInterface extends ModelInterface
{
    const PAGE_CONTENT_FIELD = 'content';
    const PAGE_ID_FIELD = 'page_id';
    const PAGE_NAME_FIELD = 'name';
    const PAGE_URL_FIELD = 'url';

    public function getContent(): string;
    public function getId(): int;
    public function getName(): string;
    public function getUrl(): string;
}
