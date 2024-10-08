<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\User;

use Romchik38\Server\Models\Sql\Repository;
use Romchik38\Site1\Api\Models\User\UserRepositoryInterface;
use Romchik38\Site1\Api\Models\User\UserModelInterface;
use Romchik38\Site1\Api\Models\User\UserFactoryInterface;
use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;

class UserRepository extends Repository implements UserRepositoryInterface
{

    /**
     * Find a user by proveded email address
     * 
     * @param string $email
     * @throws NoSuchEntityException
     * @return UserModelInterface
     */
    public function getByEmail(string $email): UserModelInterface
    {
        $arr = $this->list(
            'WHERE ' 
            . UserModelInterface::EMAIL_FIELD
            .' = $1', 
            [$email]
        );
        if (count($arr) === 0) {
            throw new NoSuchEntityException('row with email ' . $email
                . ' do not present in the ' . $this->table . ' table');
        }

        return array_shift($arr);
    }

    public function getByUserName(string $userName): UserModelInterface
    {
        $arr = $this->list(
            'WHERE ' 
            . UserModelInterface::USER_NAME_FIELD 
            .' = $1', 
            [$userName]
        );
        if (count($arr) === 0) {
            throw new NoSuchEntityException('row with user_name ' . $userName
                . ' do not present in the ' . $this->table . ' table');
        }

        return array_shift($arr);
    }
}
