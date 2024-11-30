<?php

declare(strict_types=1);

namespace Romchik38\Site1\Controllers\Sitemap;

use Romchik38\Server\Api\Controllers\ControllerInterface;

/** 
 * Converts controller tree to output format 
 * Place right getSitemapLinkTree for concrete View
 * @api
*/
interface SitemapLinkTreeInterface
{
    /** @return mixed Output for view */
    public function getSitemapLinkTree(ControllerInterface $controller): mixed;
}
