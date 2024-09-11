<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Virtual\GoogleReCaptcha;

use Romchik38\Server\Models\Model;
use Romchik38\Site1\Api\Models\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelInterface;

class VirtualGoogleReCaptchaModel extends Model implements VirtualGoogleReCaptchaModelInterface
{

    public function getActionName(): string
    {
        return $this->getData(VirtualGoogleReCaptchaModelInterface::ACTION_NAME_FIELD);
    }

    public function getActive(): bool
    {
        return (bool)$this->getData(VirtualGoogleReCaptchaModelInterface::ACTIVE_FIELD);
    }

    public function getScore(): float
    {
        return (float)$this->getData(VirtualGoogleReCaptchaModelInterface::SCORE_FIELD);
    }

    public function setActionName(string $actionName): VirtualGoogleReCaptchaModelInterface
    {
        $this->setData(VirtualGoogleReCaptchaModelInterface::ACTION_NAME_FIELD, $actionName);
        return $this;
    }

    public function setActive(bool $active): VirtualGoogleReCaptchaModelInterface
    {
        $this->setData(VirtualGoogleReCaptchaModelInterface::ACTIVE_FIELD, $active);
        return $this;
    }

    public function setScore(float $score): VirtualGoogleReCaptchaModelInterface
    {
        $this->setData(VirtualGoogleReCaptchaModelInterface::SCORE_FIELD, $score);
        return $this;
    }
}
