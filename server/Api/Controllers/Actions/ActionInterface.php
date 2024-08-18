<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Controllers\Actions;

use Romchik38\Server\Api\Controllers\ControllerInterface;

interface ActionInterface
{

    /**
     * returns current controller
     * 
     * @return ControllerInterface
     */
    public function getController(): ControllerInterface;

    /**
     * set corrent controller to the action
     * 
     * @param ControllerInterface $controller [current controller]
     */
    public function setController(ControllerInterface $controller);
}
