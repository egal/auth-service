<?php

namespace App\Models;

use Egal\Model\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property $id {@primary-key} {@property-type field} {@validation-rules required|string|unique:permissions}
 * @property $name {@property-type field} {@validation-rules required|string|unique:permissions}
 * @property $is_default {@property-type field} {@validation-rules bool}
 * @property $created_at {@property-type field}
 * @property $updated_at {@property-type field}
 *
 * @action getItem {@roles-access developer}
 * @action getItems {@roles-access developer}
 * @action create {@roles-access developer}
 * @action update {@roles-access developer}
 * @action delete {@roles-access developer}
 */
class Permission extends Model
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
        static::created(function (Permission $permission) {
            if ($permission->is_default) {
                Role::all()->each(function (Role $role) use ($permission) {
                    $role->permissions()->attach($permission->id);
                });
            }
        });
    }

}
