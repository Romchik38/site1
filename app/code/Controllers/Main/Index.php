<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Main;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Site1\Api\Models\PageRepositoryInterface;
use Romchik38\Server\Controllers\Errors\NotFoundException;

class Index implements ControllerInterface
{
    public function __construct(
        protected ViewInterface $view,
        protected PageRepositoryInterface $pageRepository
    ) {
    }
    public function execute($action): string
    {
        if ($action === '') {
            $action = 'index';
        }

        $arr = $this->pageRepository->list(' WHERE url = $1', [$action]);

        if (count($arr) === 0) {
            throw new NotFoundException('Sorry, requested resource ' . $action . ' not found');
        } else {
            $page = $arr[0];
            $this->view
                ->setMetadata(ViewInterface::TITLE, $page->getData('name'))
                ->setControllerData($page);
            return $this->view->toString();
        }
    }
}
