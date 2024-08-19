<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Results\Controller;

interface ControllerResultInterface
{
    const RESPONSE_FIELD = 'response';
    const PATH_FIELD = 'path';
    /** 
     * returns result from the action
     * 
     * @return string [action response]
     */
    public function getResponse(): string;

    /**
     * returns the full path to action
     * direction from root to action
     * 
     * @return array ['root', 'controller_name', ... 'action_name']
     */
    public function getPath(): array;
}
