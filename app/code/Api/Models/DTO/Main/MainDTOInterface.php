<?php

namespace Romchik38\Site1\Api\Models\DTO\Main;

use Romchik38\Server\Api\Models\DTOInterface;
use Romchik38\Site1\Api\Models\DTO\ActionDTOInterface;
use Romchik38\Site1\Api\Models\PageModelInterface;

interface MainDTOInterface extends DTOInterface, ActionDTOInterface {

    public const PAGE_FIELD = 'page';

    public function getPage(): PageModelInterface;

}