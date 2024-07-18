<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services;

use Romchik38\Site1\Api\Services\UserRecoveryEmailInterface;
use Romchik38\Server\Api\Models\Entity\EntityRepositoryInterface;
use Romchik38\Site1\Services\Error\UserRecoveryEmail\CantSendRecoveryLinkException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;

class UserRecoveryEmail implements UserRecoveryEmailInterface {

    public function __construct(
        protected EntityRepositoryInterface $entityRepository,
        protected int $entityId,
        protected string $recoveryFieldName
    ){        
    }

    public function sendRecoveryLink(string $email): void
    {
        try {
            $entity = $this->entityRepository->getById($this->entityId);
        } catch(NoSuchEntityException $e) {
            throw new CantSendRecoveryLinkException('Check recovery email settings (entity)');
        }
        
        $recoverySender = $entity->$this->recoveryFieldName;
        if ($recoverySender === null) {
            throw new CantSendRecoveryLinkException('Check recovery email settings (sender)');
        }


    }
}