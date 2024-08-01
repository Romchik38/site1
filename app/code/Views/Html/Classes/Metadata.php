<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Classes;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Romchik38\Server\Api\Models\DTO\DTOInterface;
use Romchik38\Server\Api\Models\Entity\EntityModelInterface;
use Romchik38\Server\Api\Models\Entity\EntityRepositoryInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Views\Http\Errors\CannotCreateHeaderError;
use Romchik38\Site1\Api\Models\DTO\Footer\FooterDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\Footer\FooterDTOInterface;
use Romchik38\Site1\Api\Models\DTO\Header\HeaderDTOFactoryInterface;
use Romchik38\Site1\Api\Views\MetadataInterface;
use Romchik38\Site1\Api\Models\DTO\Header\HeaderDTOInterface;

/**
 * Class collect metadata for header, nav, footer
 */
class Metadata implements MetadataInterface {
    protected EntityModelInterface $entity;

    public function __construct(
        protected HeaderDTOFactoryInterface $headerDTOFactory,
        protected FooterDTOFactoryInterface $footerDTOFactory,
        protected EntityRepositoryInterface $entityRepository,
        int $entityId,
        protected LoggerInterface $logger
    )
    {
        // Header
        try {
            $this->entity = $this->entityRepository->getById($entityId);
        } catch (NoSuchEntityException $e) {
            // It's a problem, because site does not work as expected
            $this->logger->log(LogLevel::ERROR, $this::class . ': Entity with id: ' . $entityId . ' was not found. Check config');
            throw new CannotCreateHeaderError(MetadataInterface::HEADER_METADATA_ERROR);
        }
    }

    public function getHeaderData(): HeaderDTOInterface
    {
        return $this->headerDTOFactory->create(
            $this->entity->{HeaderDTOInterface::PHONE_NUMBER_TEXT},
            $this->entity->{HeaderDTOInterface::ADDRESS_TEXT},
            $this->entity->{HeaderDTOInterface::NOTICE}
        );

    }

    public function getFooterData(): FooterDTOInterface
    {
        return $this->footerDTOFactory->create(
            $this->entity->{FooterDTOInterface::COPYRIGHTS_TEXT}
        );
    }
}