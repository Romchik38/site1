<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services\Http;

use Romchik38\Site1\Api\Models\DTO\RegisterDTOInterface;
use Romchik38\Site1\Api\Services\RequestInterface;
use Romchik38\Server\Api\Models\DTOFactoryInterface;

class Request implements RequestInterface {

    public function __construct(
        protected DTOFactoryInterface $userDTOFactory
    ) {  
    }

    public function getMessage(): string
    {
        return $_GET[RequestInterface::MESSAGE_FIELD] 
            ?? $_POST[RequestInterface::MESSAGE_FIELD]
            ?? '';
    }

    public function getPassword(): string
    {
        return $_POST[RequestInterface::PASSWORD_FIELD] ?? '';
    }

    /**
     * Returns DTO with register data for next checks
     *
     * @return RegisterDTOInterface
     */
    public function getUserRegisterData(): RegisterDTOInterface
    {
        /** @var RegisterDTOInterface $userRegisterDTO */
        $userRegisterDTO = $this->userDTOFactory->create();
        $fieldNames = $userRegisterDTO->getFieldsNames();
        $fields = [];
        foreach ($fieldNames as $fieldName) {
            $fields[$fieldName] = $_POST[$fieldName] ?? '';
        }
        $userRegisterDTO->setFields($fields);
        return $userRegisterDTO;
    }

    /**
     * Returns username or ''
     *
     * @return string
     */
    public function getUserName(): string
    {
        return $_POST[RequestInterface::USERNAME_FIELD] ?? '';
    }
}