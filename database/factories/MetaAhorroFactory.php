<?php

namespace Database\Factories;

use App\Models\MetaAhorro;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MetaAhorroFactory extends Factory
{
    protected $model = MetaAhorro::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nombre' => fake()->word(),
            'monto_objetivo' => fake()->randomFloat(2, 1000, 10000),
            'monto_actual' => fake()->randomFloat(2, 0, 500),
            'fecha_limite' => fake()->optional()->date(),
        ];
    }
}
