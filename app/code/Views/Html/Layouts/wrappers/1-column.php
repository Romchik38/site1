<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html;

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
        <div class="container">
            <div class="row">
                {$headerHtml}
            </div>
            <div class="row">
                {$navHtml}
            </div>
            <div class="row">
                {$sectionHtml}
            </div>
            <div class="row">
                {$footerHtml}
            </div>
        </div>
    ONECOLUMN;
};
