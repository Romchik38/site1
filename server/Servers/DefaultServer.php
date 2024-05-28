<?php

declare(strict_types=1);

namespace Romchik38\Server\Servers;

use Romchik38\{Container, NotFoundException};
use Romchik38\Server\Routers\DefaultRouter;
use Romchik38\Server\Api\Server;

class DefaultServer implements Server
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

    public function run(): void
    {
        try {
            $router = $this->container->get(DefaultRouter::class);
            $result = $router->execute();
            $response = $result->getResponse();
            $headres = $result->getHeaders();
            $statusCode = $result->getStatusCode();
            foreach ($headres as $header) {
                var_dump($header);
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
