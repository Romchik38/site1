<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\DTO\Controller;

use Romchik38\Server\Api\Models\DTO\Controller\ControllerDTOInterface;
use Romchik38\Server\Models\DTO;

/** MUST BE a real DTO, not a model 
 * 
 * ---->  move methods set... to __construct params <------
 * 
 */
class ControllerDTO extends DTO implements ControllerDTOInterface
{
    protected array $path = [];
    protected array $children = [];

    public function __construct(
        protected readonly string $name
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): array
    {
        return $this->path;
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function setChild(ControllerDTOInterface $child): ControllerDTOInterface
    {
        $this->children[] = $child;
        return $this;
    }

    public function setPath(string $path): ControllerDTOInterface
    {
        array_unshift($this->path, $path);
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            ControllerDTOInterface::NAME_FIELD => $this->name,
            ControllerDTOInterface::PATH_FIELD => $this->path,
            ControllerDTOInterface::CHILDREN_FIELD => $this->children
        ];
    }
}