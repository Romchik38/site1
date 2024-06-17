<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Classes\Main;

use Romchik38\Server\Views\PageView;

class Index extends PageView
{
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
                'name' => 'Some Page',
                'url' => '#',
                'alt' => 'To Some Page'
            ]
        ];
    }

    protected function prepareMetaData(): void
    {
        /** Header */

        /** Menu */
        $this->createNav();
        /** Footer */
        $this->createFooter();
    }
}
