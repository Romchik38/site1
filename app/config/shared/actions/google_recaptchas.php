<?php

declare(strict_types=1);

/** 
 * [ class => string[], ... ]
 *   or
 * [ class => [ 
 *              dynamic_name => string[], 
 *              ...
 *            ]
 *   ...
 * ]
 */
return [
    \Romchik38\Site1\Controllers\Login\DynamicAction::class => [
        'recovery' => ['login_recovery_emeil_submit']
    ]
];