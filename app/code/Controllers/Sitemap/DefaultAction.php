<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Sitemap;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Models\DTO\Controller\ControllerDTOInterface;
use Romchik38\Server\Api\Services\SitemapInterface;
use Romchik38\Server\Controllers\Actions\Action;

class DefaultAction extends Action implements DefaultActionInterface
{

    public function __construct(
        protected readonly SitemapInterface $sitemapService
    ) {}

    public function execute(): string
    {
        $result = $this->sitemapService
            ->getRootControllerDTO($this->getController());

        $html = '<ul>Sitemap:' . $this->createHtml($result) . '</ul>';

        return $html;
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

    protected function createHtml(ControllerDTOInterface $element): string
    {
        $children = $element->getChildren();
        $path = $this->mapHome($element->getPath());
        $name = $element->getName();
        if ($name === 'root') {
            $name = '';
        }
        $link = implode('/', $path) . '/' . $name;
        if (count($children) === 0) {
            $elemName = '<a href="' . $link . '">' . $element->getName() . '</a>';
            $lastElement = '<li>' . $elemName . '</li>';
            return $lastElement;
        }
        $rowName = '<a href="' . $link . '">' . $element->getName() . '</a>';
        $rowElements = [];
        foreach ($children as $child) {
            $rowElem = $this->createHtml($child);
            $rowElements[] = $rowElem;
        }

        return '<li>' . $rowName . '<ul>' . implode('', $rowElements) . '</ul></li>';
    }
}
