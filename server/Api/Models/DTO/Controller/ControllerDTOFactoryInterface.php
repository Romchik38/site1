<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\DTO\Controller;

interface ControllerDTOFactoryInterface
{
    /** MUST BE refactored with argements */
    /**           \      /                */
    /**            \    /                 */
    /**             \  /                  */
    /**              \/                   */
    public function create(string $name): ControllerDTOInterface;
}
