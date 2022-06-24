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
    public function run(): void
    {
        $authenticateId = 'authenticate';
        $authenticatePermissionAttributes = [
            'id' => $authenticateId,
            'name' => 'Authenticate',
            'is_default' => true
        ];
        if (!Permission::query()->find($authenticateId)) {
            Permission::query()->create($authenticatePermissionAttributes);
        }
    }

}
