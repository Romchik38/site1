<?php

declare(strict_types=1);

return function(array $metaData, string $data){
    return <<<SECTION
    <section class="container">
        <div class="row">
            {$data}
        </div>
    </section>
    SECTION;
};