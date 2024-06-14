<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Redirects;

use Romchik38\Server\Models\Repository;
use Romchik38\Server\Api\Models\RedirectRepositoryInterface;

class RedirectRepository extends Repository implements RedirectRepositoryInterface
{
    protected const URL_FIELD = 'url';
    protected const REDIRECT_FIELD = 'redirect_to';
    public function checkUrl(string $url): string
    {
        $expression = 'WHERE ' . $this::URL_FIELD . ' = $1';
        $arr = $this->list($expression, [$url]);
        if (count($arr) === 0) {
            return '';
        } else {
            $redirect = $arr[0];
            $redirectUrl = $redirect->getData($this::REDIRECT_FIELD);
            return $redirectUrl;
        }
    }
}
