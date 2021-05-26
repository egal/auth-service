<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace App\Models;

use App\Exceptions\LoginException;
use App\Exceptions\ServiceNotFoundAuthException;
use Egal\Auth\Exceptions\TokenExpiredException;
use Egal\Auth\Tokens\ServiceMasterToken;
use Egal\Auth\Tokens\ServiceServiceToken;
use Egal\Auth\Traits\Authenticatable;
use Egal\Model\Model as EgalModel;

/**
 * @property $id {@primary-key} {@property-type field} {@validation-rules required|string|unique:services}
 * @property $name {@property-type field} {@validation-rules required|string|unique:services}
 * @property $key {@property-type field} {@validation-rules required|string}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @action getItem {@roles-access developer}
 * @action getItems {@roles-access developer}
 * @action create {@roles-access developer}
 * @action update {@roles-access developer}
 * @action delete {@roles-access developer}
 *
 * @action login {@statuses-access guest}
 * @action loginToService {@statuses-access guest}
 */
class Service extends EgalModel
{

    use Authenticatable;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'key',
    ];

    protected $hidden = [
        'key',
        'created_at',
        'updated_at',
    ];

    /**
     * @param string $serviceName
     * @param string $key
     * @return string
     * @throws LoginException
     */
    public static function actionLogin(string $serviceName, string $key): string
    {
        /** @var Service $service */
        $service = self::query()
            ->where('name', '=', $serviceName)
            ->where('key', '=', $key)
            ->first();

        if (!$service) {
            throw new LoginException('Incorrect key or service name!');
        }

        $smt = new ServiceMasterToken();
        $smt->setSigningKey(config('app.service_key'));
        $smt->setAuthIdentification($service->getAuthIdentifier());

        return $smt->generateJWT();
    }

    /**
     * @param string $token
     * @param string $serviceName
     * @return string
     * @throws ServiceNotFoundAuthException
     * @throws TokenExpiredException
     */
    final public static function actionLoginToService(string $token, string $serviceName): string
    {
        /** @var ServiceMasterToken $smt */
        $smt = ServiceMasterToken::fromJWT($token, config('app.service_key'));
        $smt->isAliveOrFail();

        /** @var Service $senderService */
        $senderService = Service::query()->find($smt->getAuthIdentification());
        if (!$senderService) {
            throw new ServiceNotFoundAuthException();
        }

        /** @var Service $recipientService */
        $recipientService = Service::query()->find($serviceName);

        if (!$recipientService) {
            throw new ServiceNotFoundAuthException();
        }

        $sst = new ServiceServiceToken();
        $sst->setSigningKey($recipientService->key);
        $sst->setAuthInformation($senderService->generateAuthInformation());

        return $sst->generateJWT();
    }

    /**
     * @return array
     */
    protected function generateAuthInformation(): array
    {
        $result = $this->fresh()->toArray();
        $result['auth_identification'] = $this->{$this->getKeyName()};
        $result['service'] = $this->name;

        return $result;
    }

}
