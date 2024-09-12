<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\Virtual\GoogleReCaptcha;

use Romchik38\Server\Models\Sql\Virtual\VirtualRepository;
use Romchik38\Site1\Api\Models\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelRepositoryInterface;

class VirtualGoogleReCaptchaModelRepository extends VirtualRepository
implements VirtualGoogleReCaptchaModelRepositoryInterface
{
    public function getActiveByActionNames(array $actionNames): array
    {
        $arrLength = count($actionNames);
        if ($arrLength === 0) {
            return [];
        }

        $fields = [];
        for ($counter = 1; $counter <= $arrLength; $counter++) {
            $fields[] = 'recaptcha.action = $' . $counter;
        }

        $expression = ' WHERE recaptcha.active = true AND ('
            . implode(' OR ', $fields)  . ')';
        $result = $this->list($expression, $actionNames);
        return $result;
    }
}
