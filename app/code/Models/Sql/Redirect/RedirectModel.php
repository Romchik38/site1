<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\Redirect;

use Romchik38\Server\Models\Model;
use Romchik38\Site1\Api\Models\RedirectModelInterface;

class RedirectModel extends Model implements RedirectModelInterface
{
    protected const REDIRECT_TO_FIELD = 'redirect_to';
    protected const REDIRECT_CODE = 'redirect_code';

    public function getRedirectTo(): string
    {
        return $this->getData($this::REDIRECT_TO_FIELD);
    }
    public function getRedirectCode(): int
    {
        return (int)$this->getData($this::REDIRECT_CODE);
    }
}
