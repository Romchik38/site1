<?php

namespace Romchik38\Site1\Models\DTO\Main;

use Romchik38\Site1\Api\Models\DTO\Main\MainDTOInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;
use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;
use Romchik38\Site1\Api\Models\Page\PageModelInterface;

class MainDTO extends DefaultViewDTO implements MainDTOInterface
{

    public function __construct(
        PageModelInterface $page,
        string $name,
        string $description
    ) {
        $this->data[$this::PAGE_FIELD] = $page;
        $this->data[DefaultViewDTOInterface::DEFAULT_NAME_FIELD] = $name;
        $this->data[DefaultViewDTOInterface::DEFAULT_DESCRIPTION_FIELD] = $description;
    }

    public function getPage(): PageModelInterface
    {
        return $this->getData($this::PAGE_FIELD);
    }

    /** todo this is null */
    public function getActionName(): string
    {
        return $this->getData($this::ACTION_FIELD_NAME);
    }
}
