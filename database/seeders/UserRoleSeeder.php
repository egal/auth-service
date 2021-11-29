<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRoleAttributes = [
            'id' => 'user',
            'name' => 'User',
            'is_default' => true
        ];
        if (!(new Role())->fill($userRoleAttributes)->exists()) {
            Role::factory()->create($userRoleAttributes);
        }
    }

}
