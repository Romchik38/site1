<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\PageNotFound;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Controllers\Actions\Action;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Site1\Api\Views\DefaultPageViewInterface;

class DefaultAction extends Action implements DefaultActionInterface
{
    public function __construct(
        protected readonly DefaultPageViewInterface $defaultPageView,
        protected readonly DefaultViewDTOFactoryInterface $defaultViewDTOFactory,
    ) {}

    public function execute(): string
    {
        $responseText = '404 Error - the page you are requested was not found on the server.';

        $defaultDTO = $this->defaultViewDTOFactory->create(
            'Page Not Found',
            '404 Page ( not found on the server )',
            $responseText
        );
        return $this->defaultPageView
            ->setControllerData($defaultDTO)
            ->toString();
    }
}
