<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\Request\Http;

use Romchik38\Server\Api\Services\Request\Http\ServerRequestInterface;

class ServerRequest extends Request implements ServerRequestInterface
{
    public function getParsedBody() {
        /** 1. retriving $_POST */
        $headers = apache_request_headers();
        $contentType = $headers['application/x-www-form-urlencoded'] ?? 
            $headers['multipart/form-data'] ?? [];

        
        /** 2. sending body content */
    }
}
