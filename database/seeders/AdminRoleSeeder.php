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
    public function run(): void
    {
        $adminId = 'admin';
        $adminRoleAttributes = [
            'id' => $adminId,
            'name' => 'Administrator',
            'is_default' => false
        ];
        if (!Role::query()->find($adminId)) {
            Role::query()->create($adminRoleAttributes);
        }
    }

}
