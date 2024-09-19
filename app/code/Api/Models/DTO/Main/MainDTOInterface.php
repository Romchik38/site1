<?php

namespace Romchik38\Site1\Api\Models\DTO\Main;

use Romchik38\Server\Api\Models\DTO\DTOInterface;
use Romchik38\Site1\Api\Models\DTO\ActionDTOInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;
use Romchik38\Site1\Api\Models\Page\PageModelInterface;

interface MainDTOInterface extends DTOInterface, ActionDTOInterface, DefaultViewDTOInterface {

    public const PAGE_FIELD = 'page';

    public function getPage(): PageModelInterface;

}