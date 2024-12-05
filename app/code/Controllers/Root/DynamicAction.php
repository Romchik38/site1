<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Root;

use Romchik38\Server\Api\Controllers\Actions\DynamicActionInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\Action;
use Romchik38\Server\Controllers\Errors\ActionNotFoundException;
use Romchik38\Server\Controllers\Errors\DynamicActionLogicException;
use Romchik38\Server\Models\DTO\DynamicRoute\DynamicRouteDTO;
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Site1\Api\Models\DTO\Main\MainDTOFactoryInterface;
use Romchik38\Site1\Application\PageView\CantFindException;
use Romchik38\Site1\Application\PageView\FindByUrl;
use Romchik38\Site1\Application\PageView\PageViewService;
use Romchik38\Site1\Domain\Page\PageRepositoryInterface;

final class DynamicAction extends Action implements DynamicActionInterface
{
    public function __construct(
        protected readonly ViewInterface $view,
        protected readonly PageRepositoryInterface $pageRepository,
        protected readonly MainDTOFactoryInterface $mainDTOFactory,
        protected readonly PageViewService $pageViewService
    ) {}

    public function execute(string $action): string
    {
        try {
            $page = $this->pageViewService->searchPageByUrl(new FindByUrl($action));
            $mainDTO = $this->mainDTOFactory->create(
                $page,
                $page->name,
                $page->name
            );
            $this->view->setController($this->getController(), $action)->setControllerData($mainDTO);
            return $this->view->toString();
        } catch (InvalidArgumentException) {
            throw new ActionNotFoundException('Sorry, requested resource ' . $action . ' not found');
        } catch (CantFindException) {
            throw new ActionNotFoundException('Sorry, requested resource ' . $action . ' not found');
        }
    }

    /** @todo implement description */
    public function getDynamicRoutes(): array
    {
        $pages = $this->pageViewService->listAllUrlsAndNames();
        foreach ($pages as $page) {
            $routes[] = new DynamicRouteDTO(
                $page->url,
                $page->name
            );
        }
        return $routes;
    }

    public function getDescription(string $dynamicRoute): string
    {
        try {
            $pageName = $this->pageViewService->searchNameByUrl(new FindByUrl($dynamicRoute));
            return $pageName();
        } catch (InvalidArgumentException $e) {
            throw new DynamicActionLogicException(
                sprintf(
                    'Route %s value is invalid',
                    $dynamicRoute
                )
            );
        } catch (CantFindException) {
            throw new DynamicActionLogicException(
                sprintf(
                    'Description for route %s not exist',
                    $dynamicRoute
                )
            );
        }
    }
}
