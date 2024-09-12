<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services\Http;

use Romchik38\Site1\Api\Models\DTO\GoogleReCaptcha\GoogleReCaptchaDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\GoogleReCaptcha\GoogleReCaptchaDTOInterface;
use Romchik38\Site1\Api\Models\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelInterface;
use Romchik38\Site1\Api\Models\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelRepositoryInterface;
use Romchik38\Site1\Api\Services\RecaptchaInterface;
use Romchik38\Site1\Api\Services\RequestInterface;
use Romchik38\Site1\Services\Errors\Recaptcha\RecaptchaException;

class GoogleRecaptcha implements RecaptchaInterface
{

    protected string $siteKey;
    protected string $secretKey;
    protected string $apiKey;
    protected string $projectName;

    public function __construct(
        protected VirtualGoogleReCaptchaModelRepositoryInterface $reCaptchaRepository,
        array $configData,
        protected GoogleReCaptchaDTOFactoryInterface $reCaptchaDTOFactory,
        protected readonly RequestInterface $request
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

    public function checkReCaptcha(string $actionName): bool
    {
        $body = $this->request->getParsedBody();
        $tocken = $body['g-recaptcha-response'] ?? '';
        /** 1. no tocken in the request data */
        if($tocken === '') {
            return false;
        }

        return true;
    }

    /**
     * @throws RecaptchaException
     * @return GoogleReCaptchaDTOInterface[]
     */
    public function getActiveRecaptchaDTOs(array $actionNames): array
    {
        $actionLength = count($actionNames);
        if ($actionLength === 0) {
            throw new RecaptchaException('Actions list can\'t be empty');
        }

        $reCaptchaModels = $this->reCaptchaRepository->getActiveByActionNames($actionNames);
        if (count($reCaptchaModels) !== $actionLength) {
            throw new RecaptchaException(
                'Cant create recaptcha with action names '
                    . implode(', ', $actionNames) . '. Check config.'
            );
        }

        $dtos = [];
        foreach ($reCaptchaModels as $reCaptchaModel) {
            $dtos[] = $this->createDTO($reCaptchaModel);
        }
        return $dtos;
    }

    protected function createDTO(VirtualGoogleReCaptchaModelInterface $reCaptchaModel): GoogleReCaptchaDTOInterface
    {
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
    }
}
