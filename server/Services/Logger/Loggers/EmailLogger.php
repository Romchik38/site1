<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\Logger\Loggers;

use Romchik38\Server\Services\Logger\Logger;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Romchik38\Server\Api\Models\DTO\Email\EmailDTOFactoryInterface;
use Romchik38\Server\Api\Services\LoggerServerInterface;
use Romchik38\Server\Api\Services\MailerInterface;
use Romchik38\Server\Services\Errors\CantSendEmailException;

class EmailLogger extends Logger
{
    protected readonly string $fullFilePath;

    public function __construct(
        int $logLevel,
        protected LoggerInterface|null $alternativeLogger = null,
        protected MailerInterface $mailer,
        protected EmailDTOFactoryInterface $emailDTOFactory,
        protected string $recipient,
        protected string $sender
    ) {
        parent::__construct($logLevel, $alternativeLogger);
    }

    public function write(string $level, string $message)
    {
        $this->messages[] = [$level, $message];
    }

    public function sendAllLogs(): void
    {
        if (count($this->messages) === 0) {
            return;
        }

        
        // write
        $writeErrors = [];
        $date = new \DateTime();
        $dateString = $date->format(LoggerServerInterface::DATE_TIME_FORMAT);
        foreach($this->messages as $item) {
            [$level, $message] = $item;
            $subject = 'Log message';

            $message = '<p>Date: ' . $dateString . '</p><p>Level: ' 
                . $level . '</p><p>Message: ' . $message . '</p>';

            $headers = array(
                'From' => $this->sender,
                'Reply-To' => $this->sender,
                'Content-type' => 'text/html',
                'X-Mailer' => 'PHP/' . phpversion()
            );

            $emailDTO = $this->emailDTOFactory->create(
                $this->recipient,
                $subject,
                $message,
                $headers
            );
            // send 
            try {
                $this->mailer->send($emailDTO);                
            } catch (CantSendEmailException $e) {
                $writeErrors[] = $item;
            }
        }

        if (count($writeErrors) > 0) {
            // log error to alternative logger
            if ($this->alternativeLogger) {
                $this->alternativeLogger->log(LogLevel::ALERT, EmailLogger::class . ' - some logs did not send');
                $this->sendAllToalternativeLog($writeErrors);
            }
        }
    
    }
}
