<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\User;

use Romchik38\Server\Models\Sql\Repository;
use Romchik38\Site1\Api\Models\User\UserModelInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Domain\User\UserRepositoryInterface;
use Romchik38\Site1\Domain\User\VO\Username;

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

    public function getByUserName(Username $username): UserModelInterface
    {
        $arr = $this->list(
            'WHERE ' 
            . UserModelInterface::USER_NAME_FIELD 
            .' = $1', 
            [$username()]
        );
        if (count($arr) === 0) {
            throw new NoSuchEntityException('row with user_name ' . $username()
                . ' do not present in the ' . $this->table . ' table');
        }

        return array_shift($arr);
    }
}
