<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\Logger\Loggers;

use Romchik38\Server\Services\Logger\Logger;
use Romchik38\Server\Api\Services\Loggers\FileLoggerInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

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
        protected $context = null,
        protected LoggerInterface|null $alternativeLogger = null
    ) {
        parent::__construct($logLevel);
        $this->fullFilePath = $protocol . $fileName;
    }

    public function write(string $level, string $message)
    {
        $this->messages[] = [$level, $message];
    }

    protected function sendAllToalternativeLog(array $writeMessages): void {
        [$level, $message] = $writeMessages;
        $this->alternativeLogger->log($level, $message);
    }

    public function __destruct()
    {
        // 1 open file - write, pointer at the and, if the file doesn't exist, if will be created
        $fp = fopen($this->fullFilePath, 'a', $this->useIncludePath, $this->context);
        if ($fp === false) {
            // log error to alternative logger
            if ($this->alternativeLogger) {
                $this->alternativeLogger->log(LogLevel::ALERT, 'Cant\'t open file to log: ' . $this->fullFilePath );
                $this->sendAllToalternativeLog($this->messages);
            }
            return;
        }
        // 2 write
        $writeErrors = [];
        $date = new \DateTime();
        $dateString = $date->format(FileLoggerInterface::DATE_TIME_FORMAT);
        foreach($this->messages as $message) {
            [$level, $message] = $message;
            $str = '[' . $dateString . '] ' . $level . ': ' . $message . PHP_EOL;
            $writeResult = fwrite($fp, $str);
            if ($writeResult === false) {
                $writeErrors[] = [$level, $message];
            }
        }
        if (count($writeErrors) > 0) {
            // log error to alternative logger
            if ($this->alternativeLogger) {
                $this->alternativeLogger->log(LogLevel::ALERT, 'Some logs not saved to file: ' . $this->fullFilePath );
                $this->sendAllToalternativeLog($writeErrors);
            }
        }
        // 3 close
        $closeResult = fclose($fp);
        if ($closeResult === false) {
            // log error to alternative logger
            if ($this->alternativeLogger) {
                $this->alternativeLogger->log(LogLevel::ALERT, 'Can\'t close file: ' . $this->fullFilePath );
                $this->sendAllToalternativeLog($this->messages);
            }
        }
    }
}
