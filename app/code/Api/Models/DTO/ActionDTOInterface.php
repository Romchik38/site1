<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO;

interface ActionDTOInterface {
    const ACTION_FIELD_NAME = 'action_name';

    public function getActionName(): string;
}