<?php

declare(strict_types=1);

namespace Romchik38\Site1\Models\Sql\Virtual\GoogleReCaptcha;

use Romchik38\Server\Models\Sql\Virtual\VirtualRepository;
use Romchik38\Site1\Api\Models\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelRepositoryInterface;

class VirtualGoogleReCaptchaModelRepository extends VirtualRepository
implements VirtualGoogleReCaptchaModelRepositoryInterface {}
