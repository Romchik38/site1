<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services;

use Romchik38\Site1\Api\Services\UserRecoveryEmailInterface;
use Romchik38\Server\Api\Models\Entity\EntityRepositoryInterface;
use Romchik38\Site1\Services\Errors\UserRecoveryEmail\CantSendRecoveryLinkException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Models\Errors\CouldNotSaveException;
use Romchik38\Server\Api\Models\DTO\Email\EmailDTOFactoryInterface;
use Romchik38\Server\Services\Errors\CantSendEmailException;
use Romchik38\Server\Api\Services\MailerInterface;
use Romchik38\Server\Api\Models\RepositoryInterface;
use Romchik38\Site1\Services\Errors\UserRecoveryEmail\CantCreateHashException;

class UserRecoveryEmail implements UserRecoveryEmailInterface {

    public function __construct(
        protected EntityRepositoryInterface $entityRepository,
        protected int $entityId,
        protected string $recoveryFieldName,
        protected EmailDTOFactoryInterface $emailDTOFactory,
        protected MailerInterface $mailer,
        protected RepositoryInterface $recoveryRepository
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

        $hash = $this->createLink($email);

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

        try {
            $this->mailer->send($emailDTO);
        } catch (CantSendEmailException $e) {
            throw new CantSendRecoveryLinkException('Email can not be send via technical issues');
        }

    }

    protected function createLink(string $email): string {        
        $hash = base64_encode(random_bytes(20));
        try {
            /** @var \Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailInterface $recoveryEmail*/
            $recoveryEmail = $this->recoveryRepository->getById($email);
            $recoveryEmail->setUpdatedAt();
            $recoveryEmail->setHash = $hash;
        } catch (NoSuchEntityException $e) {            
            /** @var \Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailInterface $recoveryEmail */
            $recoveryEmail = $this->recoveryRepository->create();
            $recoveryEmail->setEmail($email);
            $recoveryEmail->setUpdatedAt();
            $recoveryEmail->setHash = $hash;
        }
        try {
            $this->recoveryRepository->save($recoveryEmail);
        } catch (CouldNotSaveException $e){
            throw new CantCreateHashException('Could not save hash to database for email' . $email);
        }
        return urlencode($hash);
    }
}