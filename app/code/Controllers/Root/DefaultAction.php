<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Root;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Views\ViewInterface;
use Romchik38\Server\Controllers\Actions\AbstractAction;
use Romchik38\Server\Controllers\Errors\ActionNotFoundException;
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Site1\Api\Models\DTO\Main\MainDTOFactoryInterface;
use Romchik38\Site1\Application\PageView\CantFindException;
use Romchik38\Site1\Application\PageView\FindByUrl;
use Romchik38\Site1\Application\PageView\PageViewService;
use Romchik38\Site1\Domain\Page\PageRepositoryInterface;

final class DefaultAction extends AbstractAction implements DefaultActionInterface
{
    public function __construct(
        protected readonly ViewInterface $view,
        protected readonly PageRepositoryInterface $pageRepository,
        protected readonly MainDTOFactoryInterface $mainDTOFactory,
        protected readonly PageViewService $pageViewService
    ) {}

    public function execute(): ResponseInterface
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
            $response = new Response();
            $responseBody = $response->getBody();
            $responseBody->write($this->view->toString());
            return $response->withBody($responseBody);

        } catch (InvalidArgumentException) {
            throw new ActionNotFoundException('Sorry, requested resource ' . $action . ' not found');
        } catch (CantFindException) {
            throw new ActionNotFoundException('Sorry, requested resource ' . $action . ' not found');
        }
    }

    public function getDescription(): string
    {
        return 'Home page';
    }
}
