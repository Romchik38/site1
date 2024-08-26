<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\ServerError;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Controllers\Actions\Action;
use Romchik38\Site1\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Site1\Api\Views\DefaultPageViewInterface;

class DefaultAction extends Action implements DefaultActionInterface
{
    public function __construct(
        protected readonly DefaultPageViewInterface $defaultPageView,
        protected readonly DefaultViewDTOFactoryInterface $defaultViewDTOFactory,
    ) {}

    public function execute(): string
    {
        $responseText = 'We are sorry. There is an error on our site. Please Try Again later. Or Contact us via email: admin@site1.com';

        $defaultDTO = $this->defaultViewDTOFactory->create(
            'Server Error',
            'Server Error Page',
            $responseText
        );
        return $this->defaultPageView
            ->setControllerData($defaultDTO)
            ->toString();
    }
}
