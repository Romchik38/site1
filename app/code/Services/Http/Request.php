<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services\Http;

use Romchik38\Server\Api\Services\Request\Http\ServerRequestServiceInterface;
use Romchik38\Server\Api\Services\Request\Http\UriFactoryInterface;
use Romchik38\Server\Services\Request\Http\ServerRequest;

class Request extends ServerRequest {

    public function __construct(
        protected readonly UriFactoryInterface $uriFactory,
        protected readonly ServerRequestServiceInterface $serverRequestService,
    ) {  
    }

}