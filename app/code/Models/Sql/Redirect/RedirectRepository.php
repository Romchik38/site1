<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\Redirect;

use Romchik38\Server\Models\Sql\Repository;
use Romchik38\Server\Api\Models\RedirectRepositoryInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Api\Models\RedirectModelInterface;
use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Server\Api\Models\ModelFactoryInterface;


class RedirectRepository extends Repository implements RedirectRepositoryInterface
{
    protected const URL_FIELD = 'url';
    protected const REDIRECT_FIELD = 'redirect_to';

    public function checkUrl(string $url): RedirectModelInterface
    {
        $expression = 'WHERE ' . $this::URL_FIELD . ' = $1';
        $arr = $this->list($expression, [$url]);
        if (count($arr) === 0) {
            throw new NoSuchEntityException('There is no entity: ' . $url);
        } else {
            $redirect = $arr[0];
            return  $redirect;
        }
    }

}
