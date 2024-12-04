<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Root;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\Action;
use Romchik38\Server\Controllers\Errors\NotFoundException;
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Site1\Api\Models\DTO\Main\MainDTOFactoryInterface;
use Romchik38\Site1\Application\PageView\CantFindException;
use Romchik38\Site1\Application\PageView\FindByUrl;
use Romchik38\Site1\Application\PageView\PageViewService;
use Romchik38\Site1\Domain\Page\PageRepositoryInterface;

class DefaultAction extends Action implements DefaultActionInterface
{
    public function __construct(
        protected ViewInterface $view,
        protected PageRepositoryInterface $pageRepository,
        protected MainDTOFactoryInterface $mainDTOFactory,
        protected readonly PageViewService $pageViewService
    ) {}

    public function execute(): string
    {
        $action = 'index';

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
            throw new NotFoundException('Sorry, requested resource ' . $action . ' not found');
        } catch (CantFindException) {
            throw new NotFoundException('Sorry, requested resource ' . $action . ' not found');
        }
    }

    public function getDescription(): string
    {
        return 'Home page';
    }
}
