<?php

declare(strict_types=1);

namespace Romchik38\Server\Routers\Http;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Results\Http\HttpRouterResultInterface;
use Romchik38\Server\Api\Router\Http\HttpRouterInterface;

class PlasticineRouter implements HttpRouterInterface
{
    public function __construct(
        protected readonly ControllerInterface $rootController)
    {
        
    }
    public function execute(): HttpRouterResultInterface
    {

        [$url] = explode('?', $_SERVER['REQUEST_URI']);

        $elements = explode('/', $url);

        // 2 blank elements for /
        if (count($elements) === 2 && $elements[0] === '' && $elements[1] === '') {
            $elements = [$elements[0]];
        }

        // replace blank with root
        if ($elements[0] === '') {
            $elements[0] = 'root';
        }

        $result = $this->rootController->execute($elements);
        
    }
}
