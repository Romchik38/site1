<?php

namespace Romchik38\Site1\Api\Models\DTO;

use Romchik38\Server\Api\Models\ModelInterface;

interface SessionDtoInterface extends ModelInterface {
    public function getLastVisitTime(): int;
    
    public function setLastVisitTime(int $time): SessionDtoInterface;
}