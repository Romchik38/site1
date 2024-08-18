<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Controllers\Actions;

interface DefaultActionInterface extends ActionInterface {
    public function execute(): string;
}
