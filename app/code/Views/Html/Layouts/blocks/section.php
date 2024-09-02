<?php

declare(strict_types=1);

namespace Romchik38\Site1\Views\Html\Layouts;

return function(array $metaData, string $data){

    /** @var $data we do not escape, because it's already html */

    return <<<SECTION
        <div class="row my-3">
            <section class="container">
                {$data}
            </section>
        </div>
    SECTION;
};