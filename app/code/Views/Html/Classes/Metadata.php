<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Classes;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Romchik38\Server\Api\Models\Entity\EntityRepositoryInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Views\Http\Errors\CannotCreateHeaderError;
use Romchik38\Site1\Api\Models\DTO\Header\HeaderDTOFactoryInterface;
use Romchik38\Site1\Api\Views\MetadataInterface;
use Romchik38\Site1\Api\Models\DTO\Header\HeaderDTOInterface;

/**
 * Class collect metadata for header, nav, footer
 */
class Metadata implements MetadataInterface {
    protected HeaderDTOInterface $headerData;

    public function __construct(
        protected HeaderDTOFactoryInterface $headerDTOFactory,
        protected EntityRepositoryInterface $entityRepository,
        int $entityId,
        protected LoggerInterface $logger
    )
    {
        try {
            $entity = $this->entityRepository->getById($entityId);
        } catch (NoSuchEntityException $e) {
            // It's a problem, because site does not work as expected
            $this->logger->log(LogLevel::ERROR, $this::class . ': Entity with id: ' . $entityId . ' was not found. Check config');
            throw new CannotCreateHeaderError(MetadataInterface::HEADER_METADATA_ERROR);
        }
        $this->headerData = $this->headerDTOFactory->create(
            $entity->{HeaderDTOInterface::ADDRESS_TEXT},
            $entity->{HeaderDTOInterface::PHONE_NUMBER_TEXT},
            $entity->{HeaderDTOInterface::NOTICE}
        );
    }

    public function getHeaderData(): HeaderDTOInterface
    {
        return $this->headerData;
    }
}