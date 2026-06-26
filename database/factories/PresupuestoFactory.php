<?php

namespace Database\Factories;

use App\Models\Presupuesto;
use App\Models\User;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

class PresupuestoFactory extends Factory
{
    protected $model = Presupuesto::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'categoria_id' => Categoria::factory(),
            'limite_mensual' => fake()->randomFloat(2, 100, 5000),
            'mes' => now()->month,
            'año' => now()->year,
        ];
    }
}
