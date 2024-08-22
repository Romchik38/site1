<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Root;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\Action;
use Romchik38\Server\Controllers\Errors\NotFoundException;
use Romchik38\Site1\Api\Models\DTO\Main\MainDTOFactoryInterface;
use Romchik38\Site1\Api\Models\Page\PageRepositoryInterface;
use Romchik38\Site1\Api\Models\Page\PageModelInterface;

class DefaultAction extends Action implements DefaultActionInterface
{
    public function __construct(
        protected ViewInterface $view,
        protected PageRepositoryInterface $pageRepository,
        protected MainDTOFactoryInterface $mainDTOFactory
    ) {}

    public function execute(): string
    {
        $action = 'index';

        $arr = $this->pageRepository->getByUrl($action);

        if (count($arr) === 0) {
            throw new NotFoundException('Sorry, requested resource ' . $action . ' not found');
        } else {
            /** @var PageModelInterface $page*/
            $page = $arr[0];
            $mainDTO = $this->mainDTOFactory->create(
                $page,
                $page->getName(),
                $page->getName()
            );

            $this->view->setControllerData($mainDTO);
            return $this->view->toString();
        }
    }
}
