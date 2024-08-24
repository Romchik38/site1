<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Api\Userinfo;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Controllers\Actions\Action;

/**
 * return info about rigistered user 
 * json format:
 * 
 * {
 *      "username": string
 * }
 * 
 * @api v0.0.1
 * 
 */
class DefaultAction extends Action implements DefaultActionInterface
{

    public function execute(): string {
        $response = [
            'username' => 'ser'
        ];
        
        return json_encode($response);
    }
}
