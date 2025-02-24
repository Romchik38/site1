<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\ServerError;

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

        $defaultDTO = $this->defaultViewDTOFactory->create(
            'Server Error',
            'We are sorry. There is an error on our site. Please Try Again later or contact us admin@site1.com'
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
        return 'Server error page';
    }
}
