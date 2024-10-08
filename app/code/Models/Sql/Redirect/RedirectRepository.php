<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\Redirect;

use Romchik38\Server\Models\Sql\Repository;
use Romchik38\Server\Api\Models\Redirect\RedirectRepositoryInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Api\Models\Redirect\RedirectModelInterface;
use Romchik38\Site1\Models\Redirect\RedirectModel;


class RedirectRepository extends Repository implements RedirectRepositoryInterface
{

    public function checkUrl(string $redirectFrom, string $method): RedirectModelInterface
    {
        $expression = 'WHERE ' . RedirectModel::REDIRECT_FROM_FIELD . ' = $1 AND ' 
            . RedirectModel::REDIRECT_METHOD_FIELD . ' = $2';
        $arr = $this->list($expression, [$redirectFrom, $method]);
        if (count($arr) === 0) {
            throw new NoSuchEntityException('There is no entity: ' . $redirectFrom);
        } else {
            $redirect = $arr[0];
            return  $redirect;
        }
    }

}
