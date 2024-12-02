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

class UserRecoveryEmailService
{

    const FAILED_MESSAGE = 'Recovery message can not be send via technical issues';

    protected readonly string $sender;
    protected readonly string $urlDomain;
    protected readonly string $url;

    public function __construct(
        protected EntityRepositoryInterface $entityRepository,
        int $entityId,
        string $recoveryFieldName,
        string $recoveryUrlDomain,
        string $recoveryUrl,
        protected EmailDTOFactoryInterface $emailDTOFactory,
        protected MailerInterface $mailer,
        protected RepositoryInterface $recoveryRepository,
        protected LoggerInterface $logger
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

    /**
     * @throws CantCreateRecoveryEmailTemplate On storage errors
     */
    public function createEmailTemplate(CreateEmailTemplate $command): void
    {

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

    // protected function createLink(string $email): string
    // {
    //     $hash = base64_encode(random_bytes(RecoveryEmailInterface::HASH_LENGTH));
    //     try {
    //         /** @var \Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailInterface $recoveryEmail*/
    //         $recoveryEmail = $this->recoveryRepository->getById($email);
    //         $recoveryEmail->setUpdatedAt();
    //         $recoveryEmail->setHash($hash);
    //         try {
    //             $this->recoveryRepository->save($recoveryEmail);
    //         } catch (CouldNotSaveException $e) {
    //             $this->logger->log(LogLevel::ERROR, $e->getMessage());
    //             throw new CantCreateHashException('Could not save hash to database for email' . $email);
    //         }
    //     } catch (NoSuchEntityException $e) {
    //         /** @var \Romchik38\Site1\Api\Models\RecoveryEmail\RecoveryEmailInterface $recoveryEmail */
    //         $recoveryEmail = $this->recoveryRepository->create();
    //         $recoveryEmail->setEmail($email);
    //         $recoveryEmail->setUpdatedAt();
    //         $recoveryEmail->setHash($hash);
    //         try {
    //             $this->recoveryRepository->add($recoveryEmail);
    //         } catch (CouldNotAddException $e) {
    //             $this->logger->log(LogLevel::ERROR, $e->getMessage());
    //             throw new CantCreateHashException('Could not add a hash to database for email' . $email);
    //         }
    //     }

    //     return urlencode($hash);
    // }

    public function checkHash(string $email, string $hash): bool
    {
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
