<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\Virtual\GoogleReCaptcha;

use Romchik38\Server\Api\Models\Virtual\VirtualRepositoryInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;

interface VirtualGoogleReCaptchaModelRepositoryInterface extends VirtualRepositoryInterface
{
    /**
     * @throws NoSuchEntityException
     */
    public function getActiveByActionName(string $actionName): VirtualGoogleReCaptchaModelInterface;
}
