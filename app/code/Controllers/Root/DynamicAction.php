<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Root;

use Romchik38\Server\Api\Controllers\Actions\DynamicActionInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\Action;
use Romchik38\Server\Controllers\Errors\DynamicActionLogicException;
use Romchik38\Server\Controllers\Errors\NotFoundException;
use Romchik38\Server\Models\DTO\DynamicRoute\DynamicRouteDTO;
use Romchik38\Site1\Api\Models\DTO\Main\MainDTOFactoryInterface;
use Romchik38\Site1\Api\Models\Page\PageModelInterface;
use Romchik38\Site1\Api\Models\Page\PageRepositoryInterface;

class DynamicAction extends Action implements DynamicActionInterface
{
    public function __construct(
        protected ViewInterface $view,
        protected PageRepositoryInterface $pageRepository,
        protected MainDTOFactoryInterface $mainDTOFactory
    ) {}

    public function execute(string $action): string
    {

        $arr = $this->pageRepository->getByUrl($action);

        if (count($arr) === 0) {
            throw new NotFoundException('Sorry, requested resource ' . $action . ' not found');
        } else {
            $page = $arr[0];
            $mainDTO = $this->mainDTOFactory->create($page, $page->getName(), $page->getName());
            $this->view->setController($this->getController(), $action)->setControllerData($mainDTO);
            return $this->view->toString();
        }
    }

    public function getRoutes(): array
    {
        $routes = [];
        $rows = $this->pageRepository->getUrls();
        foreach ($rows as $row) {
            $routes[] = $row[PageModelInterface::PAGE_URL_FIELD];
        }
        return $routes;
    }

    /** @todo implement description */
    public function getDynamicRoutes(): array
    {
        $rows = $this->pageRepository->getUrls();
        foreach ($rows as $name) {
            $routes[] = new DynamicRouteDTO(
                $name,
                $name . ' description'
            );
        }
        return $routes;
    }

    /** @todo implement description */
    public function getDescription(string $dynamicRoute): string
    {
        return $dynamicRoute . ' description';
    }
}
