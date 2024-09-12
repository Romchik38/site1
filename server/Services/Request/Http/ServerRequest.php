<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\Request\Http;

use Romchik38\Server\Api\Services\Request\Http\ServerRequestInterface;

class ServerRequest extends Request implements ServerRequestInterface
{
    public function getParsedBody()
    {
        /** 1. retriving $_POST */
        if(function_exists('apache_request_headers') === true) {
            $headers = apache_request_headers();
            if ($headers !== false) {
                $contentType = $headers['Content-Type'] ?? '';
                if (
                    ($contentType === 'application/x-www-form-urlencoded') ||
                    ($contentType === 'multipart/form-data')
                ) {
                    return $_POST;
                }
            }
        }

        /** 2. sending body content */
        $entityBody = file_get_contents('php://input');
        if($entityBody === '') {
            return null;
        }
        return [$entityBody];
    }
}
