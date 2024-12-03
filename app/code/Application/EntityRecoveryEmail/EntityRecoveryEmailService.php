<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\EntityRecoveryEmail;

use Romchik38\Server\Api\Models\Entity\EntityRepositoryInterface;
use Romchik38\Site1\Api\Services\RequestInterface;
use Romchik38\Site1\Application\EntityRecoveryEmail\Views\RecoveryEmail;

class EntityRecoveryEmailService
{
    public const EMAIL_HASH_FIELD = 'email_hash';
    public const FAILED_MESSAGE = 'Recovery message can not be send via technical issues';

    protected readonly string $sender;
    protected readonly string $urlDomain;
    protected readonly string $url;

    public function __construct(
        protected EntityRepositoryInterface $entityRepository,
        int $entityId,
        string $recoveryFieldName,
        string $recoveryUrlDomain,
        string $recoveryUrl
    ) {
        $entity = $this->entityRepository->getById($entityId);
        $this->sender = $entity->$recoveryFieldName;
        $this->urlDomain = $entity->$recoveryUrlDomain;
        $this->url = $entity->$recoveryUrl;

        if (
            is_null($this->sender) ||
            is_null($this->urlDomain) ||
            is_null($this->url)
        ) {
            throw new \RuntimeException('Error while init Entity Recovery Email Service');
        }
    }

    public function createEmailTemplate(CreateEmailTemplate $command): RecoveryEmail
    {

        $subject = 'Recovery link to create a new password';
        $message = '<p>Hello, user. <br>This is a recovery email. Link below. <br><a href="'
            . $this->urlDomain . $this->url . '?' . self::EMAIL_HASH_FIELD
            . '=' . $command->hash . '&'
            . RequestInterface::EMAIL_FIELD . '=' . urlencode($command->email)
            . '">Click here to recovery your password</a></p>'
            . '<p>If you do not request a password changing, please do nothing.</p>';
        $headers = array(
            'From' => $this->sender,
            'Reply-To' => $this->sender,
            'Content-type' => 'text/html',
            'X-Mailer' => 'PHP/' . phpversion()
        );

        return new RecoveryEmail(
            $subject,
            $message,
            $headers
        );
    }
}
