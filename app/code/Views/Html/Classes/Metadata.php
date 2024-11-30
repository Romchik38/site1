<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Classes;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Models\DTO\Controller\ControllerDTOInterface;
use Romchik38\Server\Api\Models\Entity\EntityModelInterface;
use Romchik38\Server\Api\Models\Entity\EntityRepositoryInterface;
use Romchik38\Server\Api\Services\SitemapInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Views\Http\Errors\CannotCreateMetadataError;
use Romchik38\Server\Api\Models\DTO\Html\Breadcrumb\BreadcrumbDTOFactoryInterface;
use Romchik38\Server\Api\Models\DTO\Html\Breadcrumb\BreadcrumbDTOInterface;
use Romchik38\Site1\Api\Models\DTO\Footer\FooterDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\Footer\FooterDTOInterface;
use Romchik38\Site1\Api\Models\DTO\Header\HeaderDTOFactoryInterface;
use Romchik38\Site1\Api\Views\MetadataInterface;
use Romchik38\Site1\Api\Models\DTO\Header\HeaderDTOInterface;
use Romchik38\Site1\Api\Models\DTO\Nav\NavDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\Nav\NavDTOInterface;
use Romchik38\Site1\Api\Models\MenuLinks\MenuLinksRepositoryInterface;
use Romchik38\Site1\Api\Services\Menu\StaticMenuServiceInterface;
use Romchik38\Site1\Services\Errors\Menu\CouldNotCreateMenu;

/**
 * Class collect metadata for header, nav, footer
 */
class Metadata implements MetadataInterface
{
    protected EntityModelInterface $entity;

    public function __construct(
        protected HeaderDTOFactoryInterface $headerDTOFactory,
        protected NavDTOFactoryInterface $navDTOFactory,
        protected FooterDTOFactoryInterface $footerDTOFactory,
        protected EntityRepositoryInterface $entityRepository,
        int $entityId,
        protected LoggerInterface $logger,
        protected StaticMenuServiceInterface $staticMenuService,
        protected SitemapInterface $sitemapService,
        protected BreadcrumbDTOFactoryInterface $breadcrumbDTOFactory,
        protected readonly MenuLinksRepositoryInterface $menuLinksRepository
    ) {
        // Header
        try {
            $this->entity = $this->entityRepository->getById($entityId);
        } catch (NoSuchEntityException $e) {
            // It's a problem, because site does not work as expected
            $this->logger->log(LogLevel::ERROR, $this::class . ': Entity with id: ' . $entityId . ' was not found. Check config');
            throw new CannotCreateMetadataError(MetadataInterface::TECHNICAL_ISSUES_ERROR);
        }
    }

    public function getBreadcrumbs(ControllerInterface $controller, string $action): BreadcrumbDTOInterface
    {

        $controllerDTO = $this->sitemapService->getOnlyLineRootControllerDTO($controller, $action);

        /** @var MenuLinksInterface[] $menuLinks */
        $menuLinks = $this->menuLinksRepository->list('', []);
        $menuLinksHash = [];
        foreach ($menuLinks as $menuLink) {
            $menuLinksHash[$menuLink->getUrl()] = $menuLink;
        }


        $breadcrumbDTO = $this->mapControllerDTOtoBreadcrumbDTO($controllerDTO, null, $menuLinksHash);

        return $breadcrumbDTO;
    }

    public function getHeaderData(): HeaderDTOInterface
    {
        $phone = $this->entity->{HeaderDTOInterface::PHONE_NUMBER_TEXT};
        $address = $this->entity->{HeaderDTOInterface::ADDRESS_TEXT};
        $notice = $this->entity->{HeaderDTOInterface::NOTICE};
        if (
            $phone === null ||
            $address === null ||
            $notice === null
        ) {
            $this->logger->log(LogLevel::ERROR, $this::class . ': Entity with field(s): '
                . HeaderDTOInterface::PHONE_NUMBER_TEXT . ' or '
                . HeaderDTOInterface::ADDRESS_TEXT . ' or '
                . HeaderDTOInterface::NOTICE
                . ' was(ere) not found. Check config');
            throw new CannotCreateMetadataError(MetadataInterface::TECHNICAL_ISSUES_ERROR);
        }
        return $this->headerDTOFactory->create(
            $phone,
            $address,
            $notice
        );
    }

    public function getNavData(): NavDTOInterface
    {
        $menuId = $this->entity->{NavDTOInterface::NAV_MENU_ID_FIELD};
        if ($menuId === null) {
            $this->logger->log(LogLevel::ERROR, $this::class . ': Entity with field: '
                . NavDTOInterface::NAV_MENU_ID_FIELD . ' was not found. Check config');
            throw new CannotCreateMetadataError(MetadataInterface::TECHNICAL_ISSUES_ERROR);
        }
        try {
            $menuDTO = $this->staticMenuService->getMenuById((int)$menuId);
        } catch (CouldNotCreateMenu $e) {
            $this->logger->log(LogLevel::ERROR, $this::class . ': ' . $e->getMessage());
            throw new CannotCreateMetadataError(MetadataInterface::TECHNICAL_ISSUES_ERROR);
        }
        return $this->navDTOFactory->create($menuDTO);
    }

    public function getFooterData(): FooterDTOInterface
    {
        $copyrights = $this->entity->{FooterDTOInterface::COPYRIGHTS_TEXT};
        if ($copyrights === null) {
            $this->logger->log(LogLevel::ERROR, $this::class . ': Entity with field: '
                . FooterDTOInterface::COPYRIGHTS_TEXT . ' was not found. Check config');
            throw new CannotCreateMetadataError(MetadataInterface::TECHNICAL_ISSUES_ERROR);
        }
        return $this->footerDTOFactory->create(
            $copyrights
        );
    }

    protected function mapControllerDTOtoBreadcrumbDTO(
        ControllerDTOInterface $controllerDTO,
        BreadcrumbDTOInterface|null $prev,
        array $hash
    ): BreadcrumbDTOInterface {

        $name = $controllerDTO->getName();
        $path = $controllerDTO->getPath();

        array_push($path, $name);

        $firstPath = $path[0] ?? null;
        if ($firstPath === SitemapInterface::ROOT_NAME) {
            $path = array_slice($path, 1);
        }

        if ($name === SitemapInterface::ROOT_NAME) {
            $name = 'home';
        }

        $url = '/' . implode('/', $path);

        /** @var MenuLinksInterface $menuLink */
        $menuLink = $hash[$url] ?? null;
        $description = '';
        if ($menuLink !== null) {
            $name = $menuLink->getName();
            $description = $menuLink->getDescription();
        }

        $element = $this->breadcrumbDTOFactory->create(
            $name,
            $description,
            $url,
            $prev
        );

        $children = $controllerDTO->getChildren();
        if (count($children) > 0) {
            $child = $children[0];
            return $this->mapControllerDTOtoBreadcrumbDTO($child, $element, $hash);
        } else {
            return $element;
        }
    }
}
