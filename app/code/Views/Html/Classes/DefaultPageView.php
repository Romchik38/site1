<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Classes;

use Romchik38\Server\Api\Models\DTO\DTOInterface;
use Romchik38\Server\Views\Http\PageView;
use Romchik38\Site1\Api\Views\DefaultPageViewInterface;

class DefaultPageView extends PageView implements DefaultPageViewInterface
{

    protected function createHeader(DTOInterface $data) {
        
    }

    protected function createFooter()
    {
        $this->metaData[$this::FOOTER_DATA] = [
            'copyrights' => '© 2024, Site1.com, LLC.' 
        ];
    }

    protected function createNav()
    {
        $this->metaData[$this::NAV_DATA] = [
            [
                'name' => 'Home',
                'url' => '/',
                'alt' => 'To Home Page'
            ],
            [
                'name' => 'About',
                'url' => '/about',
                'alt' => 'To About Page'
            ],
            [
                'name' => 'Login',
                'url' => '/login/index',
                'alt' => 'To Login Page'
            ]
        ];
    }

    protected function prepareMetaData(DTOInterface $data): void
    {
        /** Header */
        $this->createHeader($data);
        /** Menu */
        $this->createNav();
        /** Footer */
        $this->createFooter();
    }
}
