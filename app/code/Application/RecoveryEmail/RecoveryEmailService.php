<?php

declare(strict_types=1);

namespace Romchik38\Site1\Application\RecoveryEmailService;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Romchik38\Server\Models\Errors\CouldNotAddException;
use Romchik38\Server\Models\Errors\CouldNotSaveException;
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site1\Domain\RecoveryEmail\RecoveryEmailInterface;
use Romchik38\Site1\Domain\RecoveryEmail\RecoveryEmailRepositoryInterface;
use Romchik38\Site1\Domain\RecoveryEmail\VO\Email;
use Romchik38\Site1\Domain\RecoveryEmail\VO\Hash;

final class RecoveryEmailService
{
    public function __construct(
        protected RecoveryEmailRepositoryInterface $recoveryEmailRepository,
        protected LoggerInterface $logger
    ) {}

    /** 
     * @throws InvalidArgumentException
     * @throws CantCreateHashException
     */
    protected function createHash(Create $command): Hash
    {
        $hash = Hash::create();
        $email = new Email($command->email);

        try {
            /** @var RecoveryEmailInterface $model*/
            $model = $this->recoveryEmailRepository->getById($email());
            $model->setUpdatedAt();
            $model->setHash($hash());
            try {
                $this->recoveryEmailRepository->save($model);
            } catch (CouldNotSaveException $e) {
                $this->logger->log(LogLevel::ERROR, $e->getMessage());
                throw new CantCreateHashException(
                    sprintf('Could not save hash to database for email ' . $email)
                );
            }
        } catch (NoSuchEntityException) {
            /** @var RecoveryEmailInterface $newModel */
            $newModel = $this->recoveryEmailRepository->create();
            $newModel->setEmail($email());
            $newModel->setUpdatedAt();
            $newModel->setHash($hash());
            try {
                $this->recoveryEmailRepository->add($newModel);
            } catch (CouldNotAddException $e) {
                $this->logger->log(LogLevel::ERROR, $e->getMessage());
                throw new CantCreateHashException(
                    'Could not add a hash to database for email' . $email
                );
            }
        }

        return $hash;
    }
}
