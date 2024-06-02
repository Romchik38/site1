<?php

declare(strict_types=1);

return function(array $metaData, string $data){
    return <<<SECTION
    <section class="main">
        This is a section <br>
        {$data}
    </section>
    SECTION;
};