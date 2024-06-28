<?php

declare(strict_types=1);

return function(array $data = []){
    return <<<HEADER
    <div class="container">
        <header class="border row justify-content-md-center">
            <div class="d-flex justify-content-center">
                <a href="/" title="To Home Page">
                    <img src="/media/img/logo-192x192.png" alt="Logo Site1" height="50">
                </a>
            </div>
        </header>
    </div>
    HEADER;
};