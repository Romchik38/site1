<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Classes;

use Romchik38\Server\Views\Http\PageView;
use Romchik38\Site1\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;
use Romchik38\Site1\Api\Views\DefaultPageViewInterface;
use Romchik38\Site1\Api\Views\MetadataInterface;

class DefaultPageView extends PageView implements DefaultPageViewInterface
{
    public function __construct(
        protected $generateTemplate,
        protected $controllerTemplate,
        protected MetadataInterface $metadataService
    ) {
        $this->metaData[$this::HEADER_DATA] = $metadataService->getHeaderData();
        $this->metaData[$this::NAV_DATA] = $metadataService->getNavData();
        $this->metaData[$this::FOOTER_DATA] = $metadataService->getFooterData();
    }

    protected function createHeader(DefaultViewDTOInterface $data) {
        $this->setMetadata($this::TITLE, $data->getName());
    }

    protected function createFooter(DefaultViewDTOInterface $data) {}

    protected function createNav(DefaultViewDTOInterface $data)
    {
        if ($this->controller !== null) {
            $breadcrumb = $this->metadataService->getBreadcrumbs($this->controller, $this->action);
            $this->metaData[$this::BREADCRUMB_DATA] = $breadcrumb;
        }
    }

    protected function prepareMetaData(DefaultViewDTOInterface $data): void
    {
        /** Header */
        $this->createHeader($data);
        /** Menu */
        $this->createNav($data);
        /** Footer */
        $this->createFooter($data);
    }
}
