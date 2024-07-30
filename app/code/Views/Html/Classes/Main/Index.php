<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Classes\Main;

use Romchik38\Server\Api\Models\DTO\DTOInterface;
use Romchik38\Site1\Api\Models\DTO\Main\MainDTOInterface;
use Romchik38\Site1\Views\Html\Classes\DefaultPageView;

class Index extends DefaultPageView {
    protected function createHeader($data) {
        /** @var MainDTOInterface $data */
        $page = $data->getPage();
        $this->setMetadata($this::TITLE, $page->getName());
    }
}