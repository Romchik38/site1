<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\DTO\Controller;

use Romchik38\Server\Api\Models\DTO\DTOInterface;

interface ControllerDTOInterface extends DTOInterface, \JsonSerializable
{
    /**
     * Used in jsonSerialize() method
     */
    const NAME_FIELD = 'name';
    const PATH_FIELD = 'name';
    const CHILDREN_FIELD = 'name';

    public function getName(): string;
    public function getPath(): array;
    public function getChildren(): array;

    /** MUST BE MOVED TO __construct() */
    /**           \      /             */
    /**            \    /              */
    /**             \  /               */
    /**              \/                */
    public function setChild(ControllerDTOInterface $child): ControllerDTOInterface;
    public function setPath(string $path): ControllerDTOInterface;
}