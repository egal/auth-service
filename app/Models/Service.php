<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace App\Models;

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
 */
class Service extends EgalModel
{

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

}
