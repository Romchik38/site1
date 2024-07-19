<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services;

use Romchik38\Site1\Api\Services\UserRecoveryEmailInterface;
use Romchik38\Server\Api\Models\Entity\EntityRepositoryInterface;
use Romchik38\Site1\Services\Errors\UserRecoveryEmail\CantSendRecoveryLinkException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Api\Models\DTO\Email\EmailDTOFactoryInterface;

class UserRecoveryEmail implements UserRecoveryEmailInterface {

    public function __construct(
        protected EntityRepositoryInterface $entityRepository,
        protected int $entityId,
        protected string $recoveryFieldName,
        protected EmailDTOFactoryInterface $emailDTOFactory
    ){        
    }

    public function sendRecoveryLink(string $email): void
    {
        try {
            $entity = $this->entityRepository->getById($this->entityId);
        } catch(NoSuchEntityException $e) {
            throw new CantSendRecoveryLinkException('Check recovery email settings (entity)');
        }
        
        $recoveryFieldName = $this->recoveryFieldName;

        $recoverySender = $entity->$recoveryFieldName;
        if ($recoverySender === null) {
            throw new CantSendRecoveryLinkException('Check recovery email settings (sender)');
        }

        $subject = 'Recovery link to create a new password';
        $message = 'Hello, user. This is recovery email. Link below. <br><a href="#">Click here to recovery password</a>';
        $headers = array(
            'From' => $recoverySender,
            'Reply-To' => $recoverySender,
            'Content-type' => 'text/html',
            'X-Mailer' => 'PHP/' . phpversion()
        );

        $emailDTO = $this->emailDTOFactory->create(
            $email,
            $subject,
            $message,
            $headers
        );

        $result = mail(
            $email,
            $subject,
            $message,
            $headers
        );
        
        if ($result === false) {
            throw new CantSendRecoveryLinkException('Email can not be send via technical issues');
        }
    }

    protected function createLink(): string {
        return base64_encode(random_bytes(20));
    }
}