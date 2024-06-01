<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html;

return function (array $blocks, ...$args) {

    [$metaData, $data] = $args;

    $header = $blocks['header'];
    $headerHtml = $header($metaData);

    $footer = $blocks['footer'];
    $footerHtml = $footer($metaData);

    $section = $blocks['section'];
    $sectionHtml = $section($metaData, $data);

    return <<<ONECOLUMN
        {$headerHtml}
        {$sectionHtml}
        {$footerHtml}
    ONECOLUMN;
};
