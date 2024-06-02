<?php

declare(strict_types=1);

namespace Romchik38\Server\Api;

interface View
{
    /**
     * Metadata fields
     */
    const TITLE = 'title';
    const HEADER_DATA = 'header_data';
    const NAV_DATA = 'nav_data';
    const FOOTER_DATA = 'footer_data';

    /**
     * Templates
     */
    const DEFAULT_WRAPPER = '1-column';

    public function setControllerData(string $data): View;
    public function setMetadata(string $key, string $value): View;
    public function toString(): string;
}
