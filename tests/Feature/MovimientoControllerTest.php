<?php

use App\Models\User;
use App\Models\Movimiento;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\MetaAhorro;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('lista movimientos del usuario autenticado', function () {
    Movimiento::factory()->count(3)->create(['user_id' => $this->user->id]);

    $this->get(route('movimientos.index'))
        ->assertStatus(200)
        ->assertViewHas('movimientos');
});

it('muestra formulario de creación', function () {
    $this->get(route('movimientos.create'))
        ->assertStatus(200);
});

it('crea un movimiento de ingreso', function () {
    $categoria = Categoria::factory()->create();

    $this->post(route('movimientos.store'), [
        'tipo' => 'ingreso',
        'monto' => 500,
        'fecha' => now()->format('Y-m-d'),
        'categoria_id' => $categoria->id,
    ])->assertRedirect(route('movimientos.index'));

    $this->assertDatabaseHas('movimientos', [
        'user_id' => $this->user->id,
        'tipo' => 'ingreso',
        'monto' => 500.00,
    ]);
});

it('crea un movimiento de egreso', function () {
    $categoria = Categoria::factory()->create();

    $this->post(route('movimientos.store'), [
        'tipo' => 'egreso',
        'monto' => 200,
        'fecha' => now()->format('Y-m-d'),
        'categoria_id' => $categoria->id,
    ])->assertRedirect(route('movimientos.index'));

    $this->assertDatabaseHas('movimientos', [
        'user_id' => $this->user->id,
        'tipo' => 'egreso',
        'monto' => 200.00,
    ]);
});

it('crea un movimiento de ahorro y actualiza meta', function () {
    $meta = MetaAhorro::factory()->create([
        'user_id' => $this->user->id,
        'monto_actual' => 0,
        'monto_objetivo' => 1000,
    ]);

    $this->post(route('movimientos.store'), [
        'tipo' => 'ahorro',
        'monto' => 300,
        'fecha' => now()->format('Y-m-d'),
        'meta_ahorro_id' => $meta->id,
    ])->assertRedirect(route('movimientos.index'));

    $this->assertDatabaseHas('movimientos', [
        'user_id' => $this->user->id,
        'tipo' => 'ahorro',
        'monto' => 300.00,
        'meta_ahorro_id' => $meta->id,
    ]);

    $this->assertDatabaseHas('metas_ahorro', [
        'id' => $meta->id,
        'monto_actual' => 300.00,
    ]);
});

it('no permite crear ahorro sin meta_ahorro_id', function () {
    $this->post(route('movimientos.store'), [
        'tipo' => 'ahorro',
        'monto' => 300,
        'fecha' => now()->format('Y-m-d'),
    ])->assertSessionHasErrors();
});

it('requiere categoria para ingreso/egreso', function () {
    $this->post(route('movimientos.store'), [
        'tipo' => 'ingreso',
        'monto' => 100,
        'fecha' => now()->format('Y-m-d'),
    ])->assertSessionHasErrors('categoria_id');
});

it('limpia subcategoria_id si no tiene categoria', function () {
    $this->post(route('movimientos.store'), [
        'tipo' => 'ahorro',
        'monto' => 100,
        'fecha' => now()->format('Y-m-d'),
        'meta_ahorro_id' => MetaAhorro::factory()->create(['user_id' => $this->user->id])->id,
    ])->assertRedirect(route('movimientos.index'));
});

it('muestra formulario de edición', function () {
    $movimiento = Movimiento::factory()->create(['user_id' => $this->user->id, 'tipo' => 'ingreso']);

    $this->get(route('movimientos.edit', $movimiento->id))
        ->assertStatus(200)
        ->assertViewHas('movimiento');
});

it('actualiza un movimiento', function () {
    $categoria = Categoria::factory()->create();
    $movimiento = Movimiento::factory()->create(['user_id' => $this->user->id, 'monto' => 100]);

    $this->put(route('movimientos.update', $movimiento->id), [
        'tipo' => 'ingreso',
        'monto' => 999,
        'fecha' => now()->format('Y-m-d'),
        'categoria_id' => $categoria->id,
    ])->assertRedirect(route('movimientos.index'));

    $this->assertDatabaseHas('movimientos', [
        'id' => $movimiento->id,
        'monto' => 999.00,
    ]);
});

it('recalcula meta al cambiar de ahorro a ingreso', function () {
    $meta = MetaAhorro::factory()->create([
        'user_id' => $this->user->id,
        'monto_actual' => 500,
        'monto_objetivo' => 1000,
    ]);

    $movimiento = Movimiento::factory()->create([
        'user_id' => $this->user->id,
        'tipo' => 'ahorro',
        'monto' => 500,
        'meta_ahorro_id' => $meta->id,
    ]);

    $categoria = Categoria::factory()->create();

    $this->put(route('movimientos.update', $movimiento->id), [
        'tipo' => 'ingreso',
        'monto' => 200,
        'fecha' => now()->format('Y-m-d'),
        'categoria_id' => $categoria->id,
    ])->assertRedirect(route('movimientos.index'));

    $this->assertDatabaseHas('metas_ahorro', [
        'id' => $meta->id,
        'monto_actual' => 0,
    ]);
});

it('elimina un movimiento', function () {
    $movimiento = Movimiento::factory()->create(['user_id' => $this->user->id]);

    $this->delete(route('movimientos.destroy', $movimiento->id))
        ->assertRedirect(route('movimientos.index'));

    $this->assertDatabaseMissing('movimientos', ['id' => $movimiento->id]);
});

it('resta de la meta al eliminar movimiento de ahorro', function () {
    $meta = MetaAhorro::factory()->create([
        'user_id' => $this->user->id,
        'monto_actual' => 500,
        'monto_objetivo' => 1000,
    ]);

    $movimiento = Movimiento::factory()->create([
        'user_id' => $this->user->id,
        'tipo' => 'ahorro',
        'monto' => 500,
        'meta_ahorro_id' => $meta->id,
    ]);

    $this->delete(route('movimientos.destroy', $movimiento->id));

    $this->assertDatabaseHas('metas_ahorro', [
        'id' => $meta->id,
        'monto_actual' => 0,
    ]);
});

it('filtra movimientos por tipo', function () {
    Movimiento::factory()->ingreso()->create(['user_id' => $this->user->id]);
    Movimiento::factory()->egreso()->create(['user_id' => $this->user->id]);

    $this->get(route('movimientos.index', ['tipo' => 'ingreso']))
        ->assertStatus(200);
});

it('filtra movimientos por rango de fechas', function () {
    Movimiento::factory()->create(['user_id' => $this->user->id, 'fecha' => '2025-01-01']);
    Movimiento::factory()->create(['user_id' => $this->user->id, 'fecha' => '2025-06-01']);

    $this->get(route('movimientos.index', ['desde' => '2025-05-01', 'hasta' => '2025-12-31']))
        ->assertStatus(200);
});

it('no permite modificar movimiento de otro usuario', function () {
    $otherUser = User::factory()->create();
    $movimiento = Movimiento::factory()->create(['user_id' => $otherUser->id]);

    $this->get(route('movimientos.edit', $movimiento->id))->assertStatus(404);
    $this->put(route('movimientos.update', $movimiento->id), [
        'tipo' => 'ingreso',
        'monto' => 1,
        'fecha' => now()->format('Y-m-d'),
        'categoria_id' => Categoria::factory()->create()->id,
    ])->assertStatus(404);
    $this->delete(route('movimientos.destroy', $movimiento->id))->assertStatus(404);
});

it('valida datos requeridos al crear movimiento', function () {
    $this->post(route('movimientos.store'), [])
        ->assertSessionHasErrors(['tipo', 'monto', 'fecha']);
});

it('valida monto mínimo', function () {
    $this->post(route('movimientos.store'), [
        'tipo' => 'ingreso',
        'monto' => 0,
        'fecha' => now()->format('Y-m-d'),
        'categoria_id' => Categoria::factory()->create()->id,
    ])->assertSessionHasErrors('monto');
});

it('paginación funciona en listado', function () {
    Movimiento::factory()->count(15)->create(['user_id' => $this->user->id]);

    $this->get(route('movimientos.index'))
        ->assertStatus(200);
});

it('lista sin movimientos muestra vista vacía', function () {
    $this->get(route('movimientos.index'))
        ->assertStatus(200);
});
