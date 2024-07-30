<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Classes\Login;

use Romchik38\Site1\Views\Html\Classes\DefaultPageView;
use Romchik38\Site1\Api\Models\DTO\Login\LoginDTOInterface;

class Index extends DefaultPageView {
    protected function createHeader($data) {
        /** @var LoginDTOInterface $loginDTO */
        $action = $data->getActionName();
        $this->setMetadata($this::TITLE, 'Login - ' . $action);
    }
}