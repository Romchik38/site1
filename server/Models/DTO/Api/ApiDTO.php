<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\DTO\Api;

use Romchik38\Server\Api\Models\DTO\Api\ApiDTOInterface;
use Romchik38\Server\Models\DTO;

class ApiDTO extends DTO implements ApiDTOInterface
{
    public function __construct(
        mixed $result,
        string $status
    ) {
        $this->data[$this::STATUS_FIELD] = $status;
        $this->data[$this::RESULT_FIELD] = $result;
    }

    public function getStatus(): string
    {
        return $this->data[$this::STATUS_FIELD];
    }

    public function getResult(): mixed
    {
        return $this->data[$this::RESULT_FIELD];
    }
}
