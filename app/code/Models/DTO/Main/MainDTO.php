<?php

namespace Romchik38\Site1\Models\DTO\Main;

use Romchik38\Site1\Api\Models\DTO\Main\MainDTOInterface;
use Romchik38\Server\Models\Model;
use Romchik38\Site1\Api\Models\PageModelInterface;

class MainDTO extends Model implements MainDTOInterface {

    public function getPage(): PageModelInterface
    {
        return $this->getData($this::PAGE_FIELD);
    }

    public function setPage(PageModelInterface $page): MainDTOInterface
    {
        $this->setData($this::PAGE_FIELD, $page);
        return $this;
    }
}