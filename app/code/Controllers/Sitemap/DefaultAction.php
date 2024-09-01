<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Sitemap;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Models\DTO\Controller\ControllerDTOInterface;
use Romchik38\Server\Api\Services\SitemapInterface;
use Romchik38\Server\Controllers\Actions\Action;
use Romchik38\Site1\Api\Views\DefaultPageViewInterface;
use Romchik38\Site1\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Site1\Api\Models\MenuLinks\MenuLinksInterface;
use Romchik38\Site1\Api\Models\MenuLinks\MenuLinksRepositoryInterface;
use Romchik38\Site1\Api\Models\DTO\Sitemap\SitemapDTOFactoryInterface;

/**
 * Creates a sitemap tree of public controllers's actions
 */
class DefaultAction extends Action implements DefaultActionInterface
{

    public function __construct(
        protected readonly SitemapInterface $sitemapService,
        protected readonly DefaultPageViewInterface $view,
        protected readonly SitemapDTOFactoryInterface $sitemapDTOFactory,
        protected readonly MenuLinksRepositoryInterface $menuLinksRepository
    ) {}

    public function execute(): string
    {
        $result = $this->sitemapService
            ->getRootControllerDTO($this->getController());

        /** @var MenuLinksInterface[] $menuLinks */
        $menuLinks = $this->menuLinksRepository->list('', []);


        $sitemapDTO = $this->sitemapDTOFactory->create(
            'Sitemap',
            'Sitemap Page',
            $result,
            $menuLinks
        );
        $this->view->setController($this->getController())
            ->setControllerData($sitemapDTO);

        return $this->view->toString();
    }
}
