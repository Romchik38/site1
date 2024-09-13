<?php

declare(strict_types=1);

/** 
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
    ],
    /* there is only one action name to use in Auth recovery,
    *  but it wraped in an array to save contract
    * */
    \Romchik38\Site1\Controllers\Auth\DynamicAction::class => [
        'recovery' => ['login_recovery_emeil_submit']
    ]
];
