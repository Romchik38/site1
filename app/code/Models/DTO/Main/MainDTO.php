<?php

namespace Romchik38\Site1\Models\DTO\Main;

use Romchik38\Site1\Api\Models\DTO\Main\MainDTOInterface;
use Romchik38\Server\Models\DTO;
use Romchik38\Site1\Api\Models\PageModelInterface;

class MainDTO extends DTO implements MainDTOInterface {

    public function __construct(PageModelInterface $page)
    {
        $this->data[$this::PAGE_FIELD] = $page;
    }

    public function getPage(): PageModelInterface
    {
        return $this->getData($this::PAGE_FIELD);
    }

    public function getActionName(): string
    {
        return $this->getData($this::ACTION_FIELD_NAME);    
    }
    
}