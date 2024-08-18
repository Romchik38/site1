<?php 

declare(strict_types=1);

namespace Romchik38\Server\Api\Controllers\Actions;

use Romchik38\Server\Api\Controllers\ControllerInterface;

interface ActionInterface {
    public function getController(): ControllerInterface;
    public function setController(ControllerInterface $controller);
}