<?php

namespace Database\Factories;

use App\Models\Movimiento;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\MetaAhorro;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovimientoFactory extends Factory
{
    protected $model = Movimiento::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'tipo' => 'ingreso',
            'monto' => fake()->randomFloat(2, 10, 1000),
            'fecha' => fake()->date(),
            'categoria_id' => null,
            'subcategoria_id' => null,
            'meta_ahorro_id' => null,
        ];
    }

    public function ingreso(): static
    {
        return $this->state(fn (array $attrs) => [
            'tipo' => 'ingreso',
            'categoria_id' => Categoria::factory(),
        ]);
    }

    public function egreso(): static
    {
        return $this->state(fn (array $attrs) => [
            'tipo' => 'egreso',
            'categoria_id' => Categoria::factory(),
        ]);
    }

    public function ahorro(): static
    {
        return $this->state(fn (array $attrs) => [
            'tipo' => 'ahorro',
            'categoria_id' => null,
        ]);
    }

    public function conCategoria(): static
    {
        return $this->state(fn (array $attrs) => [
            'categoria_id' => Categoria::factory(),
            'subcategoria_id' => Subcategoria::factory(),
        ]);
    }
}
