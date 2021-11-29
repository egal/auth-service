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
        dump((new Role())->fill($adminRoleAttributes)->exists());
        dump((new Role())->fill($adminRoleAttributes)->toArray());
        if (!(new Role())->fill($adminRoleAttributes)->exists()) {
            Role::factory()->create($adminRoleAttributes);
        }
    }

}
