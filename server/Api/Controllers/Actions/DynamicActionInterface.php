<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Controllers\Actions;

interface DynamicActionInterface extends ActionInterface {
    public function execute($dynamicRoute): string;
    public function getRoutes(): array;
}
