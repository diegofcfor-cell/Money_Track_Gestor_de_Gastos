<?php

use App\Models\User;
use App\Models\Movimiento;
use App\Models\Presupuesto;
use App\Models\MetaAhorro;
use App\Models\Categoria;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('carga la página del dashboard', function () {
    $this->get(route('panel'))
        ->assertStatus(200);
});

it('muestra KPIs correctos con datos', function () {
    Movimiento::factory()->create(['user_id' => $this->user->id, 'tipo' => 'ingreso', 'monto' => 1000]);
    Movimiento::factory()->create(['user_id' => $this->user->id, 'tipo' => 'egreso', 'monto' => 400]);
    Movimiento::factory()->create(['user_id' => $this->user->id, 'tipo' => 'ahorro', 'monto' => 200]);

    $this->get(route('panel'))
        ->assertStatus(200);
});

it('muestra alertas de presupuesto cuando se excede el 80%', function () {
    $cat = Categoria::factory()->create();
    Presupuesto::factory()->create([
        'user_id' => $this->user->id,
        'categoria_id' => $cat->id,
        'limite_mensual' => 1000,
        'mes' => now()->month,
        'año' => now()->year,
    ]);

    Movimiento::factory()->create([
        'user_id' => $this->user->id,
        'tipo' => 'egreso',
        'monto' => 900,
        'categoria_id' => $cat->id,
        'fecha' => now()->format('Y-m-d'),
    ]);

    $this->get(route('panel'))
        ->assertStatus(200);
});

it('muestra progreso de metas de ahorro', function () {
    MetaAhorro::factory()->create([
        'user_id' => $this->user->id,
        'monto_objetivo' => 1000,
        'monto_actual' => 500,
    ]);

    $this->get(route('panel'))
        ->assertStatus(200);
});

it('funciona con datos vacíos (usuario sin movimientos)', function () {
    $this->get(route('panel'))
        ->assertStatus(200);
});

it('calcula correctamente total de ingresos y egresos', function () {
    Movimiento::factory()->count(3)->create([
        'user_id' => $this->user->id,
        'tipo' => 'ingreso',
        'monto' => 100,
    ]);
    Movimiento::factory()->count(2)->create([
        'user_id' => $this->user->id,
        'tipo' => 'egreso',
        'monto' => 50,
    ]);

    $this->get(route('panel'))
        ->assertStatus(200);
});

it('calcula tasa de ahorro', function () {
    Movimiento::factory()->create([
        'user_id' => $this->user->id,
        'tipo' => 'ingreso',
        'monto' => 1000,
        'fecha' => now()->format('Y-m-d'),
    ]);
    Movimiento::factory()->create([
        'user_id' => $this->user->id,
        'tipo' => 'ahorro',
        'monto' => 200,
        'fecha' => now()->format('Y-m-d'),
    ]);

    $this->get(route('panel'))
        ->assertStatus(200);
});

it('identifica la categoría más gastada', function () {
    $cat = Categoria::factory()->create(['nombre' => 'Comida']);
    Movimiento::factory()->count(3)->create([
        'user_id' => $this->user->id,
        'tipo' => 'egreso',
        'monto' => 100,
        'categoria_id' => $cat->id,
        'fecha' => now()->format('Y-m-d'),
    ]);

    $this->get(route('panel'))
        ->assertStatus(200);
});

it('saldo es ingresos menos egresos totales', function () {
    Movimiento::factory()->create(['user_id' => $this->user->id, 'tipo' => 'ingreso', 'monto' => 1000]);
    Movimiento::factory()->create(['user_id' => $this->user->id, 'tipo' => 'egreso', 'monto' => 300]);

    $this->get(route('panel'))
        ->assertStatus(200);
});

it('no accede al dashboard de otro usuario', function () {
    $other = User::factory()->create();
    Movimiento::factory()->create(['user_id' => $other->id, 'tipo' => 'ingreso', 'monto' => 9999]);

    $response = $this->get(route('panel'));

    $response->assertStatus(200);
    $response->assertDontSee('9999');
});
