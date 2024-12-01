<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\UserRecoveryEmail;

use InvalidArgumentException;
use Romchik38\Site1\Api\Services\UserRecoveryEmailInterface;
use Romchik38\Server\Api\Models\Entity\EntityRepositoryInterface;
use Romchik38\Site1\Services\Errors\UserRecoveryEmail\CantSendRecoveryLinkException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Models\Errors\CouldNotSaveException;
use Romchik38\Server\Models\Errors\CouldNotAddException;
use Romchik38\Server\Api\Models\DTO\Email\EmailDTOFactoryInterface;
use Romchik38\Server\Services\Errors\CantSendEmailException;
use Romchik38\Server\Api\Services\MailerInterface;
use Romchik38\Server\Api\Models\RepositoryInterface;
use Romchik38\Site1\Services\Errors\UserRecoveryEmail\CantCreateHashException;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Romchik38\Site1\Api\Services\RequestInterface;
use Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailInterface;
use Romchik38\Site1\Domain\User\UserRepositoryInterface;
use Romchik38\Site1\Domain\User\VO\Email;

class UserRecoveryEmailService {

    const FAILED_MESSAGE = 'Recovery message can not be send via technical issues';

    public function __construct(
        protected EntityRepositoryInterface $entityRepository,
        protected int $entityId,
        protected string $recoveryFieldName,
        protected string $recoveryUrlDomain,
        protected string $recoveryUrl,
        protected EmailDTOFactoryInterface $emailDTOFactory,
        protected MailerInterface $mailer,
        protected RepositoryInterface $recoveryRepository,
        protected LoggerInterface $logger,
        protected readonly UserRepositoryInterface $userRepository
    ){        
    }

    /**
     * @throws InvalidArgumentException
     */
    public function sendRecoveryLink(RecoveryEmail $command): void
    {
        $email = new Email($command->email);

        /* 3. Check if email is present in the database */
        try {
            $this->userRepository->getByEmail($email());
        } catch (NoSuchEntityException $e) {
            throw new NoSuchEmailException(sprintf(
                'Email %s do not exist',
                $command->email
            ));
        }
        
        /** 
         * @todo replase failed message with real issue. Check all service and controller on output 
         * */
        try {
            $entity = $this->entityRepository->getById($this->entityId);
        } catch(NoSuchEntityException $e) {
            $this->logger->log(LogLevel::ERROR, $e->getMessage());
            throw new CantSendRecoveryLinkException($this::FAILED_MESSAGE);
        }
        
        $recoverySender = $entity->{$this->recoveryFieldName};
        $recoveryUrlDomain = $entity->{$this->recoveryUrlDomain};
        $recoveryUrl = $entity->{$this->recoveryUrl};

        if ($recoverySender === null || 
            $recoveryUrlDomain === null || 
            $recoveryUrl === null
        ) {
            $this->logger->log(LogLevel::ERROR, 'Entity fields (sender, domain, url) for email do not configured correctly. A message can\'t be send.');
            throw new CantSendRecoveryLinkException($this::FAILED_MESSAGE);
        }

        try {
            $hash = $this->createLink($email);
        } catch (CantCreateHashException $e) {
            $this->logger->log(LogLevel::ERROR, $e->getMessage());
            throw new CantSendRecoveryLinkException($this::FAILED_MESSAGE);
        }

        $subject = 'Recovery link to create a new password';
        $message = '<p>Hello, user. <br>This is a recovery email. Link below. <br><a href="' 
            . $recoveryUrlDomain . $recoveryUrl . '?' . RequestInterface::EMAIL_HASH_FIELD 
            . '=' . $hash . '&'
            . RequestInterface::EMAIL_FIELD . '=' . urlencode($email)
            . '">Click here to recovery your password</a></p>'
            . '<p>If you do not request a password changing, please do nothing.</p>';
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
            $this->logger->log(LogLevel::DEBUG, 'Recovery email for user ' . $email . ' was sent');
        } catch (CantSendEmailException $e) {
            $this->logger->log(LogLevel::ERROR, 'Recovery email to <' . $email . '> was not sent. Mailer said: ' . $e->getMessage());
            throw new CantSendRecoveryLinkException($this::FAILED_MESSAGE);
        }

    }

    protected function createLink(string $email): string {        
        $hash = base64_encode(random_bytes(RecoveryEmailInterface::HASH_LENGTH));
        try {
            /** @var \Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailInterface $recoveryEmail*/
            $recoveryEmail = $this->recoveryRepository->getById($email);
            $recoveryEmail->setUpdatedAt();
            $recoveryEmail->setHash($hash);
            try {
                $this->recoveryRepository->save($recoveryEmail);
            } catch (CouldNotSaveException $e){
                $this->logger->log(LogLevel::ERROR, $e->getMessage());
                throw new CantCreateHashException('Could not save hash to database for email' . $email);
            }
        } catch (NoSuchEntityException $e) {            
            /** @var \Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailInterface $recoveryEmail */
            $recoveryEmail = $this->recoveryRepository->create();
            $recoveryEmail->setEmail($email);
            $recoveryEmail->setUpdatedAt();
            $recoveryEmail->setHash($hash);
            try {
                $this->recoveryRepository->add($recoveryEmail);
            } catch (CouldNotAddException $e){
                $this->logger->log(LogLevel::ERROR, $e->getMessage());
                throw new CantCreateHashException('Could not add a hash to database for email' . $email);
            }
        }

        return urlencode($hash);
    }

    public function checkHash(string $email, string $hash): bool {
        try {
            /** @var \Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailInterface $recoveryEmail*/
            $recoveryEmail = $this->recoveryRepository->getById($email);
            if ($hash !== $recoveryEmail->getHash()) {
                return false;
            }
            $hashTime = (int)(new \DateTime($recoveryEmail->getUpdatedAt()))->format('U');
            $now = (int)(new \DateTime())->format('U');
            if (($now - $hashTime) > RecoveryEmailInterface::VALID_TIME) {
                return false;
            }
        } catch (NoSuchEntityException $e) {  
            return false;
        }

        return true;
    }
}