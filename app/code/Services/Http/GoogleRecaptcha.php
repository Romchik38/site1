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

    /**
     * Check recaptcha on success
     * 
     * @throws RecaptchaException
     * @return bool
     */
    public function checkReCaptcha(string $actionName): bool
    {
        $body = $this->request->getParsedBody();
        $tocken = $body['g-recaptcha-response'] ?? '';
        /** 1. no tocken in the request data */
        if ($tocken === '') {
            return false;
        }

        $dtos = $this->getActiveRecaptchaDTOs([$actionName]);
        $dto = $dtos[0];
        $result = $this->getCheck($tocken, $dto);

        /** 2. check success */
        $success = $result['success'] ?? null;
        if ($success === null) {
            throw new RecaptchaException('Field success not found in google response. check api');
        }
        if ($success === false) {
            return false;
        }

        /** 3. Check action name */
        $action = $result['action'] ?? null;
        if ($action === null) {
            throw new RecaptchaException('Field action not found in google response. check api');
        }
        if ($action !== $actionName) {
            throw new RecaptchaException('Unexpected action name: ' . $action . '. Expecting: ' . $actionName);
        }

        /** 4. Check score */
        $score = $result['score'] ?? null;
        if ($score === null) {
            throw new RecaptchaException('Field score not found in google response. check api');
        }
        if (
            ((float)$score) >= $dto->getScore()
        ) {
            return true;
        }
        return false;
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

    /**
     * Not enterprise google reCaptcha check
     * 
     * @throws RecaptchaException if read errors occurs
     */
    protected function getCheck(string $tocken, GoogleReCaptchaDTOInterface $dto): array
    {
        // $url = 'https://recaptchaenterprise.googleapis.com/v1/projects/'
        //     . $dto->getProjectName()
        //     . '/assessments?key=' . $dto->getApiKey();

        $url = 'https://www.google.com/recaptcha/api/siteverify';

        $data = array('secret' => $dto->getSecretKey(), 'response' => $tocken);
        $data = http_build_query($data);

        $context_options = array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-type: application/x-www-form-urlencoded\r\n"
                    . "Content-Length: " . strlen($data) . "\r\n",
                'content' => $data
            )
        );

        $context = stream_context_create($context_options);
        if ($context === null) {
            throw new RecaptchaException('Can\'t create context for google recaptcha check');
        }
        $fp = fopen($url, 'r', false, $context);
        if ($fp === false) {
            throw new RecaptchaException('Can\'t open url to read: ' . $url . ' while check google recaptcha');
        }
        $string = '';
        $read = true;
        while ($read === true) {
            $read = false;
            $line = fgets($fp);
            if ($line !== false) {
                $read = true;
                $string .= $line;
            }
        }
        fclose($fp);
        $result = json_decode($string, true);
        if ($result === false || $result === null) {
            throw new RecaptchaException('Unexpecting response from google server while checking recaptcha');
        }
        return $result;
    }
}
