<?php

declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\ReCaptcha\GoogleReCaptcha;

interface GoogleReCaptchaModelInterface
{
    const SCORE_FIELD = 'score';

    public function getScore(): float;
    public function setScore(float $score): GoogleReCaptchaModelInterface;
}
