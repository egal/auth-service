<?php

use App\Exceptions\PasswordHashException;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;

class UsersPasswordHashing extends Migration
{

    public function up(): void
    {
        # TODO: Реализовать на SQL
        foreach (User::query()->get() as $user) {
            /** @var User $user */
            $hashedPassword = password_hash($user->password, PASSWORD_BCRYPT);
            if (!$hashedPassword) {
                throw new PasswordHashException('Password hash error!');
            }
            $user->password = $hashedPassword;
            $user->save();
        }
    }

    public function down(): void
    {
        # TODO: Реализовать
        throw new Exception('Migrate rollback impossible!');
    }

}
