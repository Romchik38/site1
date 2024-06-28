<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\DTO;

use Romchik38\Server\Models\Model;
use Romchik38\Site1\Api\Models\DTO\RegisterDTOInterface;
use \Romchik38\Site1\Api\Services\RequestInterface;

class UserRegisterDTO extends Model implements RegisterDTOInterface {

    protected array $fieldNames = [
        RequestInterface::USERNAME_FIELD,
        RequestInterface::PASSWORD_FIELD,
        RequestInterface::FIRST_NAME_FIELD,
        RequestInterface::LAST_NAME_FIELD,
        RequestInterface::EMAIL_FIELD
    ];

    public function getFieldsNames(): array
    {
        return $this->fieldNames;
    }

    public function setFields(array $fields): RegisterDTOInterface
    {
        foreach ($fields as $key => $value) {
            $this->setData($key, $value);
        }
        return $this;
    }
}