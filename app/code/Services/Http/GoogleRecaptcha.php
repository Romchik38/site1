<?php

declare(strict_types=1);

namespace Romchik38\Site1\Services\Http;

use Psr\Http\Message\ServerRequestInterface;
use Romchik38\Site1\Api\Models\DTO\GoogleReCaptcha\GoogleReCaptchaDTOFactoryInterface;
use Romchik38\Site1\Api\Models\DTO\GoogleReCaptcha\GoogleReCaptchaDTOInterface;
use Romchik38\Site1\Api\Models\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelInterface;
use Romchik38\Site1\Api\Models\Virtual\GoogleReCaptcha\VirtualGoogleReCaptchaModelRepositoryInterface;
use Romchik38\Site1\Api\Services\RecaptchaInterface;
use Romchik38\Site1\Services\Errors\Recaptcha\RecaptchaException;

/**
 * Not enterprise google reCaptcha check
 * For enterprise recaptcha redefine getCheck with new logic
 */
class GoogleRecaptcha implements RecaptchaInterface
{

    protected string $siteKey;
    protected string $secretKey;
    protected string $apiKey;
    protected string $projectName;
    protected string $type;

    public function __construct(
        protected VirtualGoogleReCaptchaModelRepositoryInterface $reCaptchaRepository,
        array $configData,
        protected GoogleReCaptchaDTOFactoryInterface $reCaptchaDTOFactory,
        protected readonly ServerRequestInterface $request
    ) {
        /** required options */
        $this->type = $configData[GoogleReCaptchaDTOInterface::TYPE] ??
            throw new RecaptchaException(
                'Check config data: '
                    . GoogleReCaptchaDTOInterface::TYPE
            );
        $this->secretKey = $configData[GoogleReCaptchaDTOInterface::SECRET_KEY_FIELD] ??
            throw new RecaptchaException(
                'Check config data: '
                    . GoogleReCaptchaDTOInterface::SECRET_KEY_FIELD
            );
        /** only for enterprise */
        $this->apiKey = $configData[GoogleReCaptchaDTOInterface::API_KEY_FIELD] ?? '';
        $this->projectName = $configData[GoogleReCaptchaDTOInterface::PROJECT_NAME_FIELD] ?? '';
        if ($this->type === GoogleReCaptchaDTOInterface::ENTERPRISE_TYPE) {
            if ($this->apiKey === '' || $this->projectName === '') {
                throw new RecaptchaException(
                    'Check config data: '
                        . GoogleReCaptchaDTOInterface::API_KEY_FIELD
                        . ' or ' . GoogleReCaptchaDTOInterface::PROJECT_NAME_FIELD
                );
            }
        }
        /** optional */
        $this->siteKey = $configData[GoogleReCaptchaDTOInterface::SITE_KEY_FIELD] ?? '';
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

        /** 2. get DTO */
        $dtos = $this->getActiveRecaptchaDTOs([$actionName]);
        $dto = $dtos[0];

        /** 3. check type */
        if ($this->type === GoogleReCaptchaDTOInterface::NON_ENTERPRISE_TYPE) {
            $result = $this->getCheck($tocken, $dto);
        } elseif ($this->type === GoogleReCaptchaDTOInterface::ENTERPRISE_TYPE) {
            $result = $this->getCheckEnterprise($tocken, $dto);
        } else {
            throw new RecaptchaException('Wrong google recaptcha type. Check config');
        }

        /** 4. check success */
        $success = $result['success'] ?? null;
        if ($success === null) {
            throw new RecaptchaException('Field success not found in google response. check api');
        }
        if ($success === false) {
            return false;
        }

        /** 5. Check action name */
        $action = $result['action'] ?? null;
        if ($action === null) {
            throw new RecaptchaException('Field action not found in google response. check api');
        }
        if ($action !== $actionName) {
            throw new RecaptchaException('Unexpected action name: ' . $action . '. Expecting: ' . $actionName);
        }

        /** 6. Check score */
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
     * Expecting in the __construct:
     *   $this->url = 'https://www.google.com/recaptcha/api/siteverify';
     * 
     * @throws RecaptchaException if read errors occurs
     */
    protected function getCheck(string $tocken, GoogleReCaptchaDTOInterface $dto): array
    {

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

        return $this->readData($context_options, $url);
    }

    /**
     * Read data for enterprise recaptchas
     */
    protected function getCheckEnterprise(string $tocken, GoogleReCaptchaDTOInterface $dto): array
    {
        // $url = 'https://recaptchaenterprise.googleapis.com/v1/projects/'
        //     . $dto->getProjectName()
        //     . '/assessments?key=' . $dto->getApiKey();

        /** @todo implement this */

        return [];
    }

    /** 
     * Make the request to google service an get a response
     * 
     * @throws RecaptchaException on errors
     * @return array parsed json data response
     */
    protected function readData(array $context, string $url): array
    {
        $context = stream_context_create($context);
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
