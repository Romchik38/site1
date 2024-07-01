<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\OrganizationEntity;

use Romchik38\Server\Api\Models\ModelInterface;

interface OrganizationEntityModelInterface extends ModelInterface {
    const EMAIL_CONTACT_RECOVERY = 'email_contact_recovery';

    public function getEmailContactRecovery(): string|null;

    public function setEmailContactRecovery(string $email): OrganizationEntityModelInterface;
}