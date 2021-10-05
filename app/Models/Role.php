<?php

namespace App\Models;

use Egal\Model\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property $id {@primary-key} {@property-type field} {@validation-rules required|string|unique:permissions}
 * @property $name {@property-type field} {@validation-rules required|string|unique:permissions}
 * @property $is_default {@property-type field} {@validation-rules bool}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @property Permission[] $permissions {@property-type relation}
 *
 * @action getItem {@roles-access developer}
 * @action getItems {@roles-access developer}
 * @action create {@roles-access developer}
 * @action update {@roles-access developer}
 * @action delete {@roles-access developer}
 */
class Role extends Model
{

    use HasFactory;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'is_default'
    ];

    protected $guarder = [
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function (Role $role) {
            $defaultPermissions = Permission::query()
                ->where('is_default', true)
                ->get();
            $role->permissions()
                ->attach($defaultPermissions->pluck('id'));
        });
        static::created(function (Role $role) {
            if ($role->is_default) {
                User::all()->each(function (User $user) use ($role) {
                    $user->roles()->attach($role->id);
                });
            }
        });
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

}
