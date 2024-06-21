<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Page;

use Romchik38\Server\Models\Repository;
use Romchik38\Site1\Api\Models\User\UserRepositoryInterface;
use Romchik38\Site1\Api\Models\User\UserModelInterface;
use Romchik38\Site1\Api\Models\User\UserFactoryInterface;
use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;

class UserRepository extends Repository implements UserRepositoryInterface
{

    public function __construct(
        protected DatabaseInterface $database,
        protected UserFactoryInterface $userFactory,
        protected string $table,
        protected string $primaryFieldName
    ) {
    }

    /**
     * Create an user entity from provided row
     *   or
     * an empty entity if the row wasn't provided
     *
     * @param array $row [explicite description]
     *
     * @return UserModelInterface
     */
    public function create(array $row = null): UserModelInterface
    {
        $entity = $this->userFactory->create();
        if ($row !== null) {
            foreach ($row as $key => $value) {
                $entity->setData($key, $value);
            }
        }

        return $entity;
    }

    public function getByUserName(string $userName): UserModelInterface
    {
        $arr = $this->list(' WHERE url = $1', [$userName]);
        if (count($arr) === 0) {
            throw new NoSuchEntityException('row with user_name ' . $userName
                . ' do not present in the ' . $this->table . ' table');
        }

        return array_shift($arr);
    }
}
