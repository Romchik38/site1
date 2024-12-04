<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Sitemap;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Controllers\Actions\Action;
use Romchik38\Site1\Api\Views\DefaultPageViewInterface;
use Romchik38\Site1\Controllers\Sitemap\DefaultAction\SitemapDTO;

/**
 * Creates a sitemap tree of public controllers's actions
 */
class DefaultAction extends Action implements DefaultActionInterface
{

    public function __construct(
        protected readonly DefaultPageViewInterface $view,
        protected readonly SitemapLinkTreeInterface $sitemapLinkTree
    ) {}

    public function execute(): string
    {
        $output = $this->sitemapLinkTree->getSitemapLinkTree($this->getController());

        $sitemapDTO = new SitemapDTO(
            'Sitemap',
            'Sitemap Page',
            $output
        );
        $this->view->setController($this->getController())
            ->setControllerData($sitemapDTO);

        return $this->view->toString();
    }
    
    public function getDescription(): string {
        return 'Sitemap page';
    }
}
