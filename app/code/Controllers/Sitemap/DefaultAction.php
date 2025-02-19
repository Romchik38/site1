<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Sitemap;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Controllers\Actions\Action;
use Romchik38\Site1\Api\Views\DefaultPageViewInterface;
use Romchik38\Site1\Controllers\Sitemap\DefaultAction\SitemapDTO;

/**
 * Creates a sitemap tree of public controllers's actions
 */
final class DefaultAction extends Action implements DefaultActionInterface
{

    public function __construct(
        protected readonly DefaultPageViewInterface $view,
        protected readonly SitemapLinkTreeInterface $sitemapLinkTree
    ) {}

    public function execute(): ResponseInterface
    {
        $output = $this->sitemapLinkTree->getSitemapLinkTree($this->getController());

        $sitemapDTO = new SitemapDTO(
            'Sitemap',
            'Sitemap Page',
            $output
        );
        $this->view->setController($this->getController())
            ->setControllerData($sitemapDTO);
        $response = new Response();
        $responseBody = $response->getBody();
        $responseBody->write($this->view->toString());
        return $response->withBody($responseBody);
    }

    public function getDescription(): string
    {
        return 'Sitemap page';
    }
}
