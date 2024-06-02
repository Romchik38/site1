<?php

declare(strict_types=1);

return function(array $data = []){
    return <<<NAV
    <nav>
        <ul class="menu">
            <li><a href="#">Home</a></li> 
            <li><a href="#">About</a></li>
            <li><a href="#">Some Page</a></li>
        </ul>
    </nav>
    NAV;
};