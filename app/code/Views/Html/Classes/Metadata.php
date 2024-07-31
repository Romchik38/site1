<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Classes;

use Romchik38\Site1\Api\Models\DTO\Header\HeaderDTOFactoryInterface;
use Romchik38\Site1\Api\Views\MetadataInterface;
use Romchik38\Site1\Api\Models\DTO\Header\HeaderDTOInterface;

/**
 * Class collect metadata for header, nav, footer
 */
class Metadata implements MetadataInterface {
    protected HeaderDTOInterface $headerData;

    public function __construct(
        protected HeaderDTOFactoryInterface $headerDTOFactory
    )
    {
        $this->headerData = $this->headerDTOFactory->create(
            'asd',
            '11111',
            'ffff'
        );
    }

    public function getHeaderData(): HeaderDTOInterface
    {
        return $this->headerData;
    }
}