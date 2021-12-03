<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersDebugSeeder extends Seeder
{

    public function run()
    {
        /** @var Role $role */
        $role = Role::query()->create();
        $users = User::query()->count(5)->create();
        /** @var User $user */
        foreach ($users as $user) {
            $user->roles()->attach($role->id);
        }
    }

}
