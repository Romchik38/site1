<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\MenuLinks;

use Romchik38\Server\Api\Models\ModelInterface;

interface MenuLinksInterface extends ModelInterface
{
    const LINK_ID_FIELD = 'link_id';
    const NAME_FIELD = 'name';
    const URL_FIELD = 'url';
    const DESCRIPTION_FIELD = 'description';

    public function getId(): int;
    public function getName(): string;
    public function getUrl(): string;
    public function getDescription(): string;

    public function setId(int $id): MenuLinksInterface;
    public function setName(string $name): MenuLinksInterface;
    public function setUrl(string $url): MenuLinksInterface;
    public function setDescription(string $description): MenuLinksInterface;
}
