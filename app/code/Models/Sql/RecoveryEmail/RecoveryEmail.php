<?php

declare(strict_types=1);

namespace Romchick38\Site1\Models\Sql\RecoveryEmail;

use Romchik38\Server\Models\Model;
use Romchick38\Site1\Api\Models\RecoveryEmail\RecoveryEmailInterface;

class RecoveryEmail extends Model implements RecoveryEmailInterface{

    public function getEmail(): string {
        return $this->data[$this::EMAIL_FIELD];
    }

    public function getHash(): string {
        return $this->data[$this::HASH_FIELD];
    }

    public function getUpdatedAt(): string {
        return $this->data[$this::UPDATED_AT_FIELD];
    }

    public function setEmail(string $email): RecoveryEmailInterface {
        $this->data[$this::EMAIL_FIELD] = $email;
        return $this;
    }

    public function setHash(string $hash): RecoveryEmailInterface {
        $this->data[$this::HASH_FIELD] = $hash;
        return $this;
    }
    
    /**
     * use setUpdatedAt() without an argument to set now() time
     * overwise setUpdatedAt('exact time') to set what you 
     * 
     * @param string $dateTime [a datetime string like '2024-07-22 16:14:06']
     * @return RecoveryEmailInterface
     */
    public function setUpdatedAt(string $dateTime = ''): RecoveryEmailInterface {
        if ($dateTime === '') {
            $date = new \DateTime();
            $this->data[$this::UPDATED_AT_FIELD] = $date->format(
                RecoveryEmailInterface::DATE_TIME_FORMAT
            );
        } else {
            $this->data[$this::UPDATED_AT_FIELD] = $dateTime;
        }
        return $this;
    }
}