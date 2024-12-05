<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\ServerError;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Controllers\Actions\Action;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface;
use Romchik38\Site1\Api\Views\DefaultPageViewInterface;

final class DefaultAction extends Action implements DefaultActionInterface
{
    public function __construct(
        protected readonly DefaultPageViewInterface $defaultPageView,
        protected readonly DefaultViewDTOFactoryInterface $defaultViewDTOFactory,
    ) {}

    public function execute(): string
    {

        $defaultDTO = $this->defaultViewDTOFactory->create(
            'Server Error',
            'We are sorry. There is an error on our site. Please Try Again later or contact us admin@site1.com'
        );
        return $this->defaultPageView
            ->setControllerData($defaultDTO)
            ->toString();
    }

    public function getDescription(): string
    {
        return 'Server error page';
    }
}
