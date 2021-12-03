<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class AuthenticatePermissionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authenticatePermissionAttributes = [
            'id' => 'authenticate',
            'name' => 'Authenticate',
            'is_default' => true
        ];
        if (!(new Permission())->fill($authenticatePermissionAttributes)->exists()) {
            Permission::query()->create($authenticatePermissionAttributes);
        }
    }

}
