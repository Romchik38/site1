<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\Virtual\GoogleReCaptcha;

use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Models\Sql\Virtual\VirtualRepository;
use Romchik38\Site1\Api\Models\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelInterface;
use Romchik38\Site1\Api\Models\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelRepositoryInterface;

class VirtualGoogleReCaptchaModelRepository extends VirtualRepository
implements VirtualGoogleReCaptchaModelRepositoryInterface
{
    public function getActiveByActionName(string $actionName): VirtualGoogleReCaptchaModelInterface
    {
        $expression = ' WHERE recaptcha.active = true AND recaptcha.action = $1';
        $result = $this->list($expression, [$actionName]);
        if (count($result) !== 1) {
            throw new NoSuchEntityException('Entity with action name ' . $actionName . ' not present in the database');
        }
        return $result[0];
    }
}
