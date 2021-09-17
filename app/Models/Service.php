<?php

namespace App\Models;

use App\Exceptions\LoginException;
use App\Exceptions\ServiceNotFoundAuthException;
use Egal\Auth\Exceptions\TokenExpiredException;
use Egal\Auth\Tokens\ServiceMasterToken;
use Egal\Auth\Tokens\ServiceServiceToken;

/**
 * @action login            {@statuses-access guest}
 * @action loginToService   {@statuses-access guest}
 */
class Service
{

    protected string $name;
    protected string $key;

    public static function find($name): ?self
    {
        $config = config('app.services.' . $name);

        if (!$config) {
            return null;
        }

        $result = new static();
        $result->name = $name;
        $result->key = $config['key'];

        return $result;
    }

    /**
     * @throws LoginException
     */
    public static function actionLogin(string $serviceName, string $key): string
    {
        $service = static::find($serviceName);

        if (!$service || $service->key !== $key) {
            throw new LoginException('Incorrect key or service name!');
        }

        $smt = new ServiceMasterToken();
        $smt->setSigningKey(config('app.service_key'));
        $smt->setAuthIdentification($service->name);

        return $smt->generateJWT();
    }

    /**
     * @throws ServiceNotFoundAuthException|TokenExpiredException
     */
    final public static function actionLoginToService(string $token, string $serviceName): string
    {
        /** @var ServiceMasterToken $smt */
        $smt = ServiceMasterToken::fromJWT($token, config('app.service_key'));
        $smt->isAliveOrFail();

        /** @var Service $senderService */
        $senderService = static::find($smt->getAuthIdentification());
        if (!$senderService) {
            throw new ServiceNotFoundAuthException();
        }

        $recipientService = static::find($serviceName);

        if (!$recipientService) {
            throw new ServiceNotFoundAuthException();
        }

        $sst = new ServiceServiceToken();
        $sst->setSigningKey($recipientService->key);
        $sst->setAuthInformation($senderService->generateAuthInformation());

        return $sst->generateJWT();
    }

    protected function generateAuthInformation(): array
    {
        $result['auth_identification'] = $this->name;
        $result['service'] = $this->name;

        return $result;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getName(): string
    {
        return $this->name;
    }

}
