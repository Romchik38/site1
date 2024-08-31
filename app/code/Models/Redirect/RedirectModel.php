<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Redirect;

use Romchik38\Server\Models\Model;
use Romchik38\Server\Api\Models\Redirect\RedirectModelInterface;

class RedirectModel extends Model implements RedirectModelInterface
{
    const REDIRECT_FROM_FIELD = 'redirect_from';
    const REDIRECT_TO_FIELD = 'redirect_to';
    const REDIRECT_CODE = 'redirect_code';
    const REDIRECT_METHOD_FIELD = 'redirect_method';
    
    public function getRedirectFrom(): string {
        return $this->getData($this::REDIRECT_FROM_FIELD);
    }

    public function getRedirectTo(): string
    {
        return $this->getData($this::REDIRECT_TO_FIELD);
    }

    public function getRedirectCode(): int
    {
        return (int)$this->getData($this::REDIRECT_CODE);
    }

    public function getRedirectMethod(): string
    {
        return $this->getData($this::REDIRECT_METHOD_FIELD);
    }
}
