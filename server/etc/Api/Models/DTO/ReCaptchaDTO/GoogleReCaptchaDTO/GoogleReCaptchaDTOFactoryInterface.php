<?php


declare(strict_types=1);

namespace Romchik38\Site1\Api\Models\DTO\GoogleReCaptchaDTO;

use Romchik38\Site1\Models\Errors\CantCreateDTOException;

interface GoogleReCaptchaDTOFactoryInterface {
    /** 
     * @throws CantCreateDTOException
     */
    public function create(string $actionName): GoogleReCaptchaDTOInterface;
}