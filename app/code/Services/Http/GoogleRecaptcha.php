<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services\Http;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Romchik38\Server\Api\Models\DTO\DTOInterface;
use Romchik38\Server\Api\Services\LoggerServerInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Api\Models\DTO\GoogleReCaptcha\GoogleReCaptchaDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\GoogleReCaptcha\GoogleReCaptchaDTOInterface;
use Romchik38\Site1\Api\Models\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelRepositoryInterface;
use Romchik38\Site1\Api\Services\RecaptchaInterface;
use Romchik38\Site1\Services\Errors\Recaptcha\RecaptchaException;

class GoogleRecaptcha implements RecaptchaInterface
{

    protected string $siteKey;
    protected string $secretKey;
    protected string $apiKey;
    protected string $projectName;

    public function __construct(
        protected VirtualGoogleReCaptchaModelRepositoryInterface $reCaptchaRepository,
        protected LoggerServerInterface $logger,
        array $configData,
        protected GoogleReCaptchaDTOFactoryInterface $reCaptchaDTOFactory
    ) {
        $this->siteKey = $configData[GoogleReCaptchaDTOInterface::SITE_KEY_FIELD] ??
            throw new RecaptchaException(
                'Check config data: '
                    . GoogleReCaptchaDTOInterface::SITE_KEY_FIELD
            );
        $this->secretKey = $configData[GoogleReCaptchaDTOInterface::SECRET_KEY_FIELD] ??
            throw new RecaptchaException(
                'Check config data: '
                    . GoogleReCaptchaDTOInterface::SECRET_KEY_FIELD
            );
        $this->apiKey = $configData[GoogleReCaptchaDTOInterface::API_KEY_FIELD] ??
            throw new RecaptchaException(
                'Check config data: '
                    . GoogleReCaptchaDTOInterface::API_KEY_FIELD
            );
        $this->projectName = $configData[GoogleReCaptchaDTOInterface::PROJECT_NAME_FIELD] ??
            throw new RecaptchaException(
                'Check config data: '
                    . GoogleReCaptchaDTOInterface::PROJECT_NAME_FIELD
            );
    }

    public function check(string $actionName): bool
    {
        return true;
    }

    public function getActiveRecaptchaDTO(string $actionName): DTOInterface
    {
        try {
            $reCaptchaModel = $this->reCaptchaRepository->getActiveByActionName($actionName);
            $recaptchaDTO = $this->reCaptchaDTOFactory->create(
                $reCaptchaModel->getActionName(),
                $reCaptchaModel->getActive(),
                $reCaptchaModel->getScore(),
                $this->siteKey,
                $this->secretKey,
                $this->projectName,
                $this->apiKey
            );
            return $recaptchaDTO;
        } catch (NoSuchEntityException $e) {
            $this->logger->log(LogLevel::ERROR, $e->getMessage());
            throw new RecaptchaException('Cant create recaptcha with action name ' . $actionName);
        }
    }
}
