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
        Permission::factory()->create([
            'id' => 'authenticate',
            'name' => 'Authenticate',
            'is_default' => true
        ]);
    }

}
