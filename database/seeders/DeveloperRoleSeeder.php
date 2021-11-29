<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class DeveloperRoleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $developerRoleAttributes = [
            'id' => 'developer',
            'name' => 'Developer',
            'is_default' => false
        ];
        if (!(new Role())->fill($developerRoleAttributes)->exists()) {
            Role::factory()->create($developerRoleAttributes);
        }
    }

}
