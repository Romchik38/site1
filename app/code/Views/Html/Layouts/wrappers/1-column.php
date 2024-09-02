<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Layouts;

return function (array $blocks, $metaData, $data) {

    $header = $blocks['header'];
    $headerHtml = $header($metaData);

    $nav = $blocks['nav'];
    $navHtml = $nav($metaData);

    $footer = $blocks['footer'];
    $footerHtml = $footer($metaData);

    $section = $blocks['section'];
    $sectionHtml = $section($metaData, $data);

    return <<<ONECOLUMN
        <div class="container-flex">
            {$headerHtml}
            {$navHtml}
            {$sectionHtml}
            {$footerHtml}
        </div>
    ONECOLUMN;
};
