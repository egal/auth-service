<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{

    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->word,
            'name' => $this->faker->word,
            'is_default' => $this->faker->boolean
        ];
    }

}
