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
    public function run(): void
    {
        $userId = 'user';
        $userRoleAttributes = [
            'id' => $userId,
            'name' => 'User',
            'is_default' => true
        ];
        if (!Role::query()->find($userId)) {
            Role::query()->create($userRoleAttributes);
        }
    }

}
