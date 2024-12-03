<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services\Http;

use Romchik38\Server\Api\Services\Request\Http\ServerRequestServiceInterface;
use Romchik38\Server\Api\Services\Request\Http\UriFactoryInterface;
use Romchik38\Site1\Api\Services\RequestInterface as Site1RequestInterface;
use Romchik38\Server\Services\Request\Http\ServerRequest;

class Request extends ServerRequest implements Site1RequestInterface {

    public function __construct(
        protected readonly UriFactoryInterface $uriFactory,
        protected readonly ServerRequestServiceInterface $serverRequestService,
    ) {  
    }

    public function getEmail(): string
    {
        return $_POST[Site1RequestInterface::EMAIL_FIELD] 
            ?? $_GET[Site1RequestInterface::EMAIL_FIELD]
            ?? '';
    }

    public function getEmailHash(): string {
        return $_GET[Site1RequestInterface::EMAIL_HASH_FIELD] ?? '';
    }

    // public function getMessage(): string
    // {
    //     return $_GET[Site1RequestInterface::MESSAGE_FIELD] 
    //         ?? $_POST[Site1RequestInterface::MESSAGE_FIELD]
    //         ?? '';
    // }

    public function getPassword(): string
    {
        return $_POST[Site1RequestInterface::PASSWORD_FIELD] ?? '';
    }

    /**
     * Returns username or ''
     * @return string
     */
    public function getUserName(): string
    {
        return $_POST[Site1RequestInterface::USERNAME_FIELD] ?? '';
    }
}