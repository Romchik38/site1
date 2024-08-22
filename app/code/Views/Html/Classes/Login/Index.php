<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Classes\Login;

use Romchik38\Site1\Views\Html\Classes\DefaultPageView;
use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;

class Index extends DefaultPageView {
        
    /** @param LoginDTOInterface $data */
    protected function createHeader($data) {
        $this->setMetadata($this::TITLE, $data->getName());
    }
}