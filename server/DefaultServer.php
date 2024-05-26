<?php

declare(strict_types=1);

namespace Romchik38\Server;

use Romchik38\{Container, NotFoundException};
use Romchik38\Server\Routers\DefaultRouter;

class DefaultServer implements Api\Server
{
    protected $logger = null;

    public function __construct(
        protected Container $container
    ) {
        try {
            $this->logger = $this->container->get($this::CONTAINER_LOGGER_FILED);
        } catch (NotFoundException $e) {
        }
    }

    public function run()
    {
        try {
            $router = $this->container->get(DefaultRouter::class);
            $result = $router->execute();                   // Result
            $response = 'hello';                // Result->getResponse()    string   def '';
            $headres = [['asd'], ['asd', true, 200]];                  // Result->getHeaders()  []
            $statusCode = 200;                               //Result->getStatus();  def = 0;
            foreach ($headres as $header) {
                header(...$header);
            }
            if ($statusCode > 0) {
                http_response_code($statusCode);
            }
            // This must be the last string
            if (strlen($response) > 0) {
                echo $response;
            }            
        } catch (\Exception $e) {
            if ($this->logger) {
                $this->logger->error($e->getMessage());
            }
            echo $this::DEFAULT_SERVER_ERROR_MESSAGE;
            http_response_code($this::DEFAULT_SERVER_ERROR_CODE);
            exit(1);
        }
    }
}
