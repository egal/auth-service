<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace App\Models;

use App\Exceptions\EmptyPasswordException;
use App\Exceptions\LoginException;
use App\Exceptions\PasswordHashException;
use App\Exceptions\UserNotIdentifiedException;
use Egal\Auth\Exceptions\TokenExpiredException;
use Egal\Auth\Tokens\UserMasterToken;
use Egal\Auth\Tokens\UserServiceToken;
use Egal\Auth\Traits\Authenticatable;
use Egal\Model\Model;
use Egal\Model\Traits\UsesUuid;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

/**
 * @property $id {@primary-key} {@property-type field}
 * @property $email {@property-type field} {@validation-rules required|string|email|unique:users,email}
 * @property $password {@property-type field} {@validation-rules required|string}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @property Collection $roles {@property-type relation}
 * @property Collection $permissions {@property-type relation}
 *
 * @action register {@statuses-access guest}
 * @action registerByEmailAndPassword {@statuses-access guest}
 * @action login {@statuses-access guest}
 * @action loginByEmailAndPassword {@statuses-access guest}
 * @action actionLoginToService {@statuses-access guest}
 */
class User extends Model
{

    use Authenticatable,
        UsesUuid,
        HasFactory,
        HasRelationships;

    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
    ];

    protected $guarder = [
        'created_at',
        'updated_at',
    ];

    #region actions

    /**
     * @param string $email
     * @param string $password
     * @return User
     * @throws PasswordHashException
     */
    public static function actionRegister(string $email, string $password): User
    {
        return static::actionRegisterByEmailAndPassword($email, $password);
    }

    /**
     * @param string $email
     * @param string $password
     * @return User
     * @throws PasswordHashException
     * @throws Exception
     */
    public static function actionRegisterByEmailAndPassword(string $email, string $password): User
    {
        if (!$password) {
            throw new EmptyPasswordException();
        }

        $user = new static();
        $user->email = $email;
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        if (!$hashedPassword) {
            throw new PasswordHashException();
        }

        $user->password = $hashedPassword;
        $user->save();
        return $user;
    }

    /**
     * @param string $email
     * @param string $password
     * @return string
     * @throws LoginException
     * @noinspection PhpUnused
     */
    public static function actionLoginByEmailAndPassword(string $email, string $password): string
    {
        /** @var User $user */
        $user = self::query()
            ->where('email', '=', $email)
            ->first();

        if (!$user || !password_verify($password, $user->password)) {
            throw new LoginException('Incorrect Email or password!');
        }

        $umt = new UserMasterToken();
        $umt->setSigningKey(config('app.service_key'));
        $umt->setAuthIdentification($user->getAuthIdentifier());

        return $umt->generateJWT();
    }

    /**
     * @param string $token
     * @param string $serviceName
     * @return string
     * @throws LoginException
     * @throws UserNotIdentifiedException
     * @throws TokenExpiredException
     * @noinspection PhpUnused
     */
    final public static function actionLoginToService(string $token, string $serviceName): string
    {
        /** @var UserMasterToken $umt */
        $umt = UserMasterToken::fromJWT($token, config('app.service_key'));
        $umt->isAliveOrFail();

        /** @var User $user */
        $user = static::query()->find($umt->getAuthIdentification());
        /** @var Service $service */
        $service = Service::query()->find($serviceName);
        if (!$user) {
            throw new UserNotIdentifiedException();
        }
        if (!$service) {
            $thisServiceName = config('app.service_name');
            if ($serviceName === $thisServiceName) {
                $service = new Service();
                $service->id = $thisServiceName;
                $service->name = $thisServiceName;
                $service->key = config('app.service_key');
                $service->save();
            } else {
                throw new LoginException('Service not found!');
            }
        }

        $ust = new UserServiceToken();
        $ust->setSigningKey($service->key);
        $ust->setAuthInformation($user->generateAuthInformation());

        return $ust->generateJWT();
    }

    #endregion actions

    #region relations

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function permissions(): HasManyDeep
    {
        return $this->hasManyDeep(
            Permission::class,
            [UserRole::class, Role::class, RolePermission::class],
            ['user_id', 'id', 'role_id', 'id'],
            ['id', 'role_id', 'id', 'permission_id']
        );
    }

    #endregion relations

    protected static function boot()
    {
        parent::boot();
        static::created(function (User $user) {
            $defaultRoles = Role::query()
                ->where('is_default', true)
                ->get();
            $user->roles()
                ->attach($defaultRoles->pluck('id'));
        });
    }

    protected function generateAuthInformation(): array
    {
        return array_merge(
            $this->fresh()->toArray(),
            [
                'auth_identification' => $this->{$this->getKeyName()},
                'roles' => array_unique($this->roles->pluck('id')->toArray()),
                'permissions' => array_unique($this->permissions->pluck('id')->toArray())
            ]
        );
    }

}
