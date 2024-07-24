<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\Logger\Loggers;

use Romchik38\Server\Services\Logger\Logger;
use Romchik38\Server\Api\Services\Loggers\FileLoggerInterface;

class FileLogger extends Logger implements FileLoggerInterface
{
    protected array $messages = [];
    protected readonly string $fullFilePath;

    /**
     * @param string $protocol [ file:// (default), http://, ftp:// etc.]
     */
    public function __construct(
        string $fileName,
        int $logLevel,
        string $protocol = FileLoggerInterface::DEFAULT_PROTOCOL,
        protected readonly bool $useIncludePath = false,
        protected $context = null
    ) {
        parent::__construct($logLevel);
        $this->fullFilePath = $protocol . $fileName;
    }

    public function write(string $level, string $message)
    {
        $this->messages[] = [$level, $message];
    }

    public function __destruct()
    {
        // 1 open file - write, pointer at the and, if the file doesn't exist, if will be created
        $fp = fopen($this->fullFilePath, 'a', $this->useIncludePath, $this->context);
        if ($fp === false) {
            // log error to alternative logger
            // ...
            return;
        }
        // 2 write
        $writeErrors = [];
        foreach($this->messages as $message) {
            [$level, $message] = $message;
            $str = $level . ': ' . $message . PHP_EOL;
            $writeResult = fwrite($fp, $str);
            if ($writeResult === false) {
                $writeErrors[] = $str;
            }
        }
        if (count($writeErrors) > 0) {
            // log error to alternative logger
            // ...
        }
        // 3 close
        $closeResult = fclose($fp);
        if ($closeResult === false) {
            // log error to alternative logger
            // ...
        }
    }
}
