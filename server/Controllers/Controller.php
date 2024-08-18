<?php

declare(strict_types=1);

namespace Romchik38\Server\Controllers;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Controllers\Errors\NoSuchControllerException;

/**
 * Controller tasks:
 * 
 *   0 - the path does not match with controller path
 *      0.1 - throw NotFoundException
 *   1  the path equal with controller path
 *      1.1 - there is a next controller
 *          - transfer control to next controller
 *      1.2 - if there is no next controller
 *          1.2.1 - execute dynamic action if present
 *              1.2.1.1 - dynamic action present, route is known
 *                  1.2.1.1.1 - return the result
 *              1.2.1.2 - dynamic action present, but route is unknown
 *                  1.2.1.2.1 - throw NotFoundException
 *              1.2.1.3 - dynamic action present, but we have at least one more next control element in the path
 *                  1.2.1.3.1 - throw NotFoundException
 *          1.2.2 - execute action
 */
class Controller implements ControllerInterface
{
    protected array $children = [];
    protected array $parents = [];
    protected Controller|null $currentParent = null;

    /**
     * must have Action
     * may have DynamicAction
     */
    public function __construct(
        protected readonly string $path,
        protected readonly ActionInterface $action,
        protected readonly DynamicAction|null $dynamicAction = null
    ) {
        $this->action->setController($this);
        if ($this->dynamicAction !== null) {
            $this->dynamicAction->setController($this);
        }
    }

    public function getName(): string
    {
        if ($this->path === '') {
            return 'root';
        }
        return $this->path;
    }

    // public function getUrl(): string
    // {
    //     return $this->path;
    // }

    public function getChild(string $name): Controller
    {
        return $this->children[$name] ??
            throw new NoSuchControllerException('children with name: ' . $name . ' does not exist');
    }

    public function setChild(Controller $child): Controller
    {
        $name = $child->getName();
        $this->children[$name] = $child;
        $child->addParent($this);
        return $this;
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function getDynamicRoutes(): array
    {
        if ($this->dynamicAction === null) {
            return [];
        }
        return $this->dynamicAction->getRoutes();
    }

    public function getCurrentParent(): Controller|null
    {
        return $this->currentParent;
    }

    public function setCurrentParent(Controller $currentParent): void
    {
        $this->currentParent = $currentParent;
    }

    public function execute(array $elements)
    {
        if (count($elements) === 0) {
            throw new \RuntimeException('Controller error: path not found');
        }

        $route = array_shift($elements);
        if ($route === $this->path) {
            if (count($elements) === 0) {
                // execute this default action
                return $this->action->execute();
            } else {
                $nextRoute = $elements[0];
                // check for controller
                try {
                    $nextController = $this->getChild($nextRoute);
                    $nextController->setCurrentParent($this);
                    return $nextController->execute($elements);
                } catch (NoSuchControllerException $e) {
                    // we do not have next controller
                    // execute dinamic action
                    if (count($elements) === 1) {
                        try {
                            return $this->dynamicAction->execute($nextRoute);
                        } catch (\RuntimeException $e) {
                            return 'Not found';         //  1.2.1.2.1 - throw NotFoundException
                        }
                    }

                    return 'Not found';                 // 1.2.1.3.1 - throw NotFoundException                
                }
            }
        } else {
            return 'Not found';                         //0.1 - throw NotFoundException
        }
    }

    public function getParents(): array
    {
        return $this->parents;
    }

    protected function addParent(Controller $parent)
    {
        $this->parents[] = $parent;
    }
}
