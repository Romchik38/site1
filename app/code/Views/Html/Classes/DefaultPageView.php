<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Classes;

use Closure;
use Romchik38\Server\Views\Http\PageView;
use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;
use Romchik38\Site1\Api\Views\DefaultPageViewInterface;
use Romchik38\Site1\Api\Views\MetadataInterface;

class DefaultPageView extends PageView implements DefaultPageViewInterface
{
    public function __construct(
        protected Closure $generateTemplate,
        protected Closure $controllerTemplate,
        protected MetadataInterface $metadataService
    ) {
        $this->metaData[$this::HEADER_DATA] = $metadataService->getHeaderData();
        $this->metaData[$this::NAV_DATA] = $metadataService->getNavData();
        $this->metaData[$this::FOOTER_DATA] = $metadataService->getFooterData();
    }

    protected function createHeader(DefaultViewDTOInterface $data) {
        $this->setMetadata($this::TITLE, $data->getName());
        $this->setMetadata($this::DESCRIPTION, $data->getDescription());
    }

    protected function createFooter(DefaultViewDTOInterface $data) {}

    protected function createNav(DefaultViewDTOInterface $data)
    {
        if ($this->controller !== null) {
            $breadcrumb = $this->metadataService->getBreadcrumbs($this->controller, $this->action);
            $this->metaData[$this::BREADCRUMB_DATA] = $breadcrumb;
        }
    }

    protected function prepareMetaData(): void
    {
        /** Header */
        $this->createHeader($this->controllerData);
        /** Menu */
        $this->createNav($this->controllerData);
        /** Footer */
        $this->createFooter($this->controllerData);
    }
}
