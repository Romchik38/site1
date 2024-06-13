<?php

declare(strict_types=1);

namespace Romchik38\Server\Model;

use Romchik38\Server\Api\Model\ModelFactoryInterface;
use Romchik38\Server\Api\Model\ModelInterface;
use Romchik38\Server\Model\Model;

class ModelFactory implements ModelFactoryInterface {

    public function create(): ModelInterface {
        return new Model();
    }

}