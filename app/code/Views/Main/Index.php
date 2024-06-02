<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Main;

use Romchik38\Server\View\PageView;

class Index extends PageView
{
    public function prepareMetaData(): void
    {
        /** Header */
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
        /** Menu */

        /** Footer */
    }
}
