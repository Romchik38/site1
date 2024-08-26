<?php

declare(strict_types=1);

namespace Romchik38\Server\Servers\Http;

use Romchik38\Server\Api\Servers\Http\HttpServerInterface;
use Romchik38\Server\Api\Services\LoggerServerInterface;
use Romchik38\Server\Api\Router\Http\HttpRouterInterface;

class DefaultServer implements HttpServerInterface
{

    public function __construct(
        protected HttpRouterInterface $router,
        protected LoggerServerInterface|null $logger = null
    ) {
    }

    public function log(): DefaultServer
    {
        if ($this->logger !== null) {
            $this->logger->sendAllLogs();
        }

        return $this;
    }

    public function run(): DefaultServer
    {
        try {
            $result = $this->router->execute();
            $response = $result->getResponse();
            $headres = $result->getHeaders();
            $statusCode = $result->getStatusCode();
            foreach ($headres as $header) {
                header(...$header);
            }

            if ($statusCode > 0) {
                http_response_code($statusCode);
            }

            if (strlen($response) > 0) {
                echo $response;
            }
            
        } catch (\Exception $e) {
            if ($this->logger) {
                $this->logger->error($e->getMessage());
            }
            http_response_code($this::DEFAULT_SERVER_ERROR_CODE);
            echo $this::DEFAULT_SERVER_ERROR_MESSAGE;
        }

        return $this;
    }
}
