<?php

namespace Romchik38\Server\Services\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

abstract class Logger extends AbstractLogger
{

    protected readonly int $logLevel;

    protected array $levels = [
        LogLevel::EMERGENCY => 0, //       Emergency: system is unusable
        LogLevel::ALERT => 1, //       Alert: action must be taken immediately
        LogLevel::CRITICAL => 2, //       Critical: critical conditions
        LogLevel::ERROR => 3, //       Error: error conditions
        LogLevel::WARNING => 4, //       Warning: warning conditions
        LogLevel::NOTICE => 5, //       Notice: normal but significant condition
        LogLevel::INFO => 6, //       Informational: informational messages
        LogLevel::DEBUG => 7  //       Debug: debug-level messages
    ];

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        if ($this->logLevel < $this->levels[$level]) {
            return;
        }

        $interpolaitedMessage = $this->interpolate($message, $context);
        $this->write($level, $interpolaitedMessage);
    }

    abstract protected function write(string $level, string $message);

    protected function interpolate($message, array $context = array())
    {
        // build a replacement array with braces around the context keys
        $replace = array();
        foreach ($context as $key => $val) {
            // check that the value can be cast to string
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }
}
