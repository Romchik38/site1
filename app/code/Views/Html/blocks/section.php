<?php

declare(strict_types=1);

return function(array $metaData, string $data){
    return <<<HEADER
    <div>this is a Section<div>
    {$data}
    HEADER;
};