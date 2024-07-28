<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Main;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Site1\Api\Models\Page\PageRepositoryInterface;
use Romchik38\Server\Controllers\Errors\NotFoundException;
use Romchik38\Site1\Api\Models\DTO\Main\MainDTOFactoryInterface;

class Index implements ControllerInterface
{
    public function __construct(
        protected ViewInterface $view,
        protected PageRepositoryInterface $pageRepository,
        protected MainDTOFactoryInterface $mainDTOFactory
    ) {
    }
    public function execute($action): string
    {
        if ($action === '') {
            $action = 'index';
        }

        $arr = $this->pageRepository->getByUrl($action);

        if (count($arr) === 0) {
            throw new NotFoundException('Sorry, requested resource ' . $action . ' not found');
        } else {
            $page = $arr[0];
            $mainDTO = $this->mainDTOFactory->create($page);
            $this->view
                ->setMetadata(ViewInterface::TITLE, $page->getData('name'))
                ->setControllerData($mainDTO);
            return $this->view->toString();
        }
    }
}
