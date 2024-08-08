<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\CompositeId;

use Romchik38\Server\Api\Models\CompositeId\CompositeIdDTOInterface;
use Romchik38\Server\Api\Models\CompositeId\CompositeIdModelInterface;
use Romchik38\Server\Models\Model;

class CompositeIdModel extends Model implements CompositeIdModelInterface
{
    public function getId(): CompositeIdDTOInterface
    {
        return $this->data[CompositeIdModelInterface::ID_NAME];
    }

    public function setId(CompositeIdDTOInterface $id): CompositeIdModelInterface
    {
        $this->data[CompositeIdModelInterface::ID_NAME] = $id;
        return $this;
    }
}