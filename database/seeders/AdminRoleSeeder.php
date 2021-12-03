<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class AdminRoleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRoleAttributes = [
            'id' => 'admin',
            'name' => 'Administrator',
            'is_default' => false
        ];
        if (!(new Role())->fill($adminRoleAttributes)->exists()) {
            Role::query()->create($adminRoleAttributes);
        }
    }

}
