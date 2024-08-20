<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\Sitemap;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Models\DTO\Controller\ControllerDTOFactoryInterface;
use Romchik38\Server\Api\Models\DTO\Controller\ControllerDTOInterface;
use Romchik38\Server\Api\Services\SitemapInterface;

class Sitemap implements SitemapInterface
{

    public function __construct(
        protected readonly ControllerDTOFactoryInterface $controllerDTOFactory
    ) {}

    /** map controller tree 
     *   to 
     * controller model tree */
    public function getRootControllerDTO(ControllerInterface $controller): ControllerDTOInterface
    {
        $first = $this->getFirst($controller);
        $ControllerDTO = $this->createElement($first);
        return $ControllerDTO;
    }

    protected function createElement(ControllerInterface $element, $parentName = '')
    {
        $children = $element->getChildren();
        if (count($children) === 0) {
            $lastElement = $this->controllerDTOFactory->create($element->getName());    // 1
            if ($parentName !== '') {
                $lastElement->setPath($parentName);
            }
            $this->addDynamicChildren($element, [], $lastElement);
            return $lastElement;
        }
        /** @var Controller $child */
        $elementName = $element->getName();
        $row = $this->controllerDTOFactory->create($elementName);                // 2 
        if ($parentName !== '') {
            $row->setPath($parentName);
        }
        $rowPath = $row->getPath();
        $childrenNames = [];
        foreach ($children as $child) {
            $childrenNames[] = $child->getName();
            $rowElem = $this->createElement($child, $row->getName());   // 3
            $row->setChild($rowElem);
            foreach ($rowPath as $path) {
                $rowElem->setPath($path);
            }
        }
        // add dynamic children - controller has children
        $this->addDynamicChildren($element, $childrenNames, $row);
        return $row;
    }

    protected function addDynamicChildren(
        ControllerInterface $element,
        array $childrenNames,
        ControllerDTOInterface $row
    ): void {
        $dynamicRoutes = $element->getDynamicRoutes();
        foreach ($dynamicRoutes as $dynamicRoute) {
            // skip dynamic routes which names equal children names
            if (array_search($dynamicRoute, $childrenNames) !== false) {
                continue;
            }
            $rowDynamicElem = $this->controllerDTOFactory->create($dynamicRoute);
            $rowDynamicElem->setPath($element->getName());
            $row->setChild($rowDynamicElem);
            foreach ($row->getPath() as $path) {
                $rowDynamicElem->setPath($path);
            }
        }
    }

    protected function getFirst(ControllerInterface $controller): ControllerInterface
    {
        $stop = false;
        $current = $controller;
        while ($stop === false) {
            $stop = true;
            $parent = $current->getCurrentParent();
            if ($parent !== null) {
                $stop = false;
                $current = $parent;
            }
        }
        return $current;
    }
}
