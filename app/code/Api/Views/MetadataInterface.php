<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Views;

use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Models\DTO\Http\Breadcrumb\BreadcrumbDTOInterface;
use Romchik38\Site1\Api\Models\DTO\Footer\FooterDTOInterface;
use Romchik38\Site1\Api\Models\DTO\Header\HeaderDTOInterface;
use Romchik38\Site1\Api\Models\DTO\Nav\NavDTOInterface;

interface MetadataInterface {
    const TECHNICAL_ISSUES_ERROR = 'We are sorry, there are some technical issues on our side. Please try later';

    public function getBreadcrumbs(ControllerInterface $controller, string $action): BreadcrumbDTOInterface;
    public function getHeaderData(): HeaderDTOInterface;
    public function getNavData(): NavDTOInterface;
    public function getFooterData(): FooterDTOInterface;
}