<?php

declare(strict_types=1);

namespace Romchik38\Server\Servers;

use Romchik38\{Container, NotFoundException};
use Romchik38\Server\Routers\DefaultRouter;
use Romchik38\Server\Api\Server;
use Romchik38\Server\Api\Services\LoggerServerInterface;

class DefaultServer implements Server
{

    public function __construct(
        protected Container $container,
        protected LoggerServerInterface|null $logger = null
    ) {
    }

    public function log(): DefaultServer
    {
        if ($this->logger === null) {
            return $this;
        }

        $this->logger->sendAllLogs();

        return $this;
    }

    public function run(): DefaultServer
    {
        try {
            $router = $this->container->get(DefaultRouter::class);
            $result = $router->execute();
            $response = $result->getResponse();
            $headres = $result->getHeaders();
            $statusCode = $result->getStatusCode();
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

        return $this;
    }
}
