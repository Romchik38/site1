<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Controllers\Actions;

interface DynamicActionInterface extends ActionInterface
{

    /** 
     * The last part of the chain.
     * Returns the result to client
     * 
     * @return string [result]
     */
    public function execute($dynamicRoute): string;

    /**
     * returns an array of routes names
     * 
     * @return string[]
     */
    public function getRoutes(): array;
}
