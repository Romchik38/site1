<?php

declare(strict_types=1);

return function(array $metaData, string $data){
    return <<<SECTION
        <div class="row my-3">
            <section class="container">
                {$data}
            </section>
        </div>
    SECTION;
};