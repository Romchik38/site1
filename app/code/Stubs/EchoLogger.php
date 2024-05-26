<?php 

declare(strict_types=1);

namespace Romchik38\Site1\Stubs;

/**
 * This is a stub logger for development
 * 
 * MUST be replaces after start using
 */
class EchoLogger {
    public function error(string $message) {
        echo '<pre>';
        echo $message;
        echo '</pre>';
    }
}