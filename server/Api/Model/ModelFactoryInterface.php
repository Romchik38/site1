<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Model;

use Romchik38\Server\Api\Model\ModelInterface;

interface ModelFactoryInterface {

    public function create(): ModelInterface;
}