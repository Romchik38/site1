<?php

declare(strict_types=1);

/**
 * start this file as a server
 * 
 */

use Romchik38\Server\Services\Request\Http\ServerRequest;
use Romchik38\Server\Services\Request\Http\UriFactory;

$request = new ServerRequest(new UriFactory());

