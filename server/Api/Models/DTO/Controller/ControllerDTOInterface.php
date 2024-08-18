<?php 

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\DTO\Controller;

interface ControllerDTOInterface extends \JsonSerializable {
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