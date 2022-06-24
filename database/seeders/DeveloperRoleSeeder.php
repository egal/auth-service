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
    public function run(): void
    {
        $developerId = 'developer';
        $developerRoleAttributes = [
            'id' => $developerId,
            'name' => 'Developer',
            'is_default' => false
        ];
        if (!Role::query()->find($developerId)) {
            Role::query()->create($developerRoleAttributes);
        }
    }

}
