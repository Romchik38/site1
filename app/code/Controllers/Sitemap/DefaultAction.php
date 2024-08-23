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

/**
 * This class MUST be html agnostic,
 * but while there are any other controller to demonstrate default view interface,
 * it will works with html.
 */
class DefaultAction extends Action implements DefaultActionInterface
{

    public function __construct(
        protected readonly SitemapInterface $sitemapService,
        protected readonly DefaultPageViewInterface $view,
        protected readonly DefaultViewDTOFactoryInterface $defaultViewDTOFactory,
        protected readonly MenuLinksRepositoryInterface $menuLinksRepository
    ) {}

    public function execute(): string
    {
        $result = $this->sitemapService
            ->getRootControllerDTO($this->getController());

        /** @var MenuLinksInterface[] $menuLinks */
        $menuLinks = $this->menuLinksRepository->list('', []);
        $menuLinksHash = [];
        foreach ($menuLinks as $menuLink) {
            $menuLinksHash[$menuLink->getUrl()] = $menuLink;
        }

        $html = '<ul>Sitemap:' . $this->createHtml($result, $menuLinksHash) . '</ul>';

        $defaultDTO = $this->defaultViewDTOFactory->create('Sitemap', 'Sitemap Page', $html);
        $this->view->setController($this->getController())
            ->setControllerData($defaultDTO);

        return $this->view->toString();
    }

    protected function mapHome($arr)
    {
        $newArr = [];
        foreach ($arr as $elem) {
            if ($elem === 'root') {
                $newArr[] = '';
            } else {
                $newArr[] = $elem;
            }
        }
        return $newArr;
    }


    protected function createHtml(ControllerDTOInterface $element, array $hash): string
    {
        $children = $element->getChildren();
        $path = $this->mapHome($element->getPath());
        $name = $element->getName();
        $url = $name;
        if ($name === 'root') {
            $url = '';
            $name = 'home';
        }
        $link = implode('/', $path) . '/' . $url;

        /** @var MenuLinksInterface $menuLink */
        $menuLink = $hash[$link] ?? null;
        $description = '';
        if ($menuLink !== null) {
            $name = $menuLink->getName();
            $description = $menuLink->getDescription();
        }

        if (count($children) === 0) {
            $elemName = '<a href="' . $link . '" title="' . $description . '">' . $name . '</a>';
            $lastElement = '<li>' . $elemName . '</li>';
            return $lastElement;
        }
        $rowName = '<a href="' . $link . '" title="' . $description . '">' . $name . '</a>';
        $rowElements = [];
        foreach ($children as $child) {
            $rowElem = $this->createHtml($child, $hash);
            $rowElements[] = $rowElem;
        }

        return '<li>' . $rowName . '<ul>' . implode('', $rowElements) . '</ul></li>';
    }
}
