<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\OrganizationEntity;

use Romchik38\Site1\Api\Models\OrganizationEntity\OrganizationEntityModelInterface;
use Romchik38\Server\Models\Model;

class OrganizationEntityModel extends Model implements OrganizationEntityModelInterface {

    public function getEmailContactRecovery(): string|null {
        return $this->getData(OrganizationEntityModelInterface::EMAIL_CONTACT_RECOVERY);
    }

    public function setEmailContactRecovery(string $email): OrganizationEntityModelInterface {
        $this->setData(OrganizationEntityModelInterface::EMAIL_CONTACT_RECOVERY, $email);
        return $this;
    }
}