<?php

declare(strict_types=1);

namespace Romchik38\Server;

use Romchik38\Container;
use Romchik38\Server\Routers\DefaultRouter;

abstract class DefaultServer implements Api\Server
{
    public function __construct(
        protected Container $container
    ) {
    }

    public function run()
    {
        try {
            $router = $this->container->get(DefaultRouter::class); 
            $result = $router->execute();                   // Result
            $response = 'hello';                // Result->getResponse()    string   def '';
            $headres = [];                  // Result->getHeaders()  []
            $statusCode = 200;                               //Result->getStatus();  def = 0;
            foreach ($headres as $header) {             
                header($header);
            }
            if($statusCode > 0) {
                http_response_code($statusCode);
            }
            if (strlen($response) > 0) {
                echo $response;
            }

        } catch(\Exception $e) {
            echo $this::DEFAULT_SERVER_ERROR_MESSAGE;
            http_response_code($this::DEFAULT_SERVER_ERROR_CODE);
            exit(1);
        }
    }
}
