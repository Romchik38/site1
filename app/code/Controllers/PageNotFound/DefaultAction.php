<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\PageNotFound;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Server\Controllers\Actions\AbstractAction;
use Romchik38\Site1\Api\Views\DefaultPageViewInterface;

final class DefaultAction extends AbstractAction implements DefaultActionInterface
{
    public function __construct(
        protected readonly DefaultPageViewInterface $defaultPageView,
        protected readonly DefaultViewDTOFactoryInterface $defaultViewDTOFactory,
    ) {}

    public function execute(): ResponseInterface
    {
        $responseText = '404 Error - the page you are requested was not found on the server.';

        $defaultDTO = $this->defaultViewDTOFactory->create(
            'Page Not Found',
            '404 Error - the page you are requested was not found on the server',
            $responseText
        );
        $html = $this->defaultPageView
            ->setControllerData($defaultDTO)
            ->toString();

        $response = new Response();
        $responseBody = $response->getBody();
        $responseBody->write($html);
        return $response->withBody($responseBody);
    }

    public function getDescription(): string
    {
        return 'Page not found';
    }
}
