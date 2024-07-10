<?php

declare(strict_types=1);

return function(array $data = []){
    return <<<HEADER
        <header class="row d-none d-md-flex my-3 mt-0">
            <div class="col-sm mt-3">
                <div class="d-flex justify-content-center">
                    <a class="link-dark text-decoration-none" href="#" title="To Home Page">
                        <span>Mazepy street 10, Kiev, Ukraine</span>
                    </a>
                </div>
            </div>
            <div class="col-sm text-end">
                <p class="h5 mt-3">0-800-500-00-00</p>
            </div>
            <div class="col-sm-3">
                <div class="mt-3">free from cellular</div>
            </div>
        </header>
    HEADER;
};