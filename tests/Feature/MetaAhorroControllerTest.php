<?php

use App\Models\User;
use App\Models\MetaAhorro;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('crea una meta de ahorro', function () {
    $this->post(route('metas.store'), [
        'nombre' => 'Viaje',
        'monto_objetivo' => 5000,
        'monto_actual' => 0,
        'fecha_limite' => now()->addYear()->format('Y-m-d'),
    ])->assertRedirect(route('presupuestos.index'));

    $this->assertDatabaseHas('metas_ahorro', [
        'user_id' => $this->user->id,
        'nombre' => 'Viaje',
        'monto_objetivo' => 5000.00,
    ]);
});

it('actualiza una meta de ahorro', function () {
    $meta = MetaAhorro::factory()->create([
        'user_id' => $this->user->id,
        'monto_objetivo' => 1000,
    ]);

    $this->put(route('metas.update', $meta->id), [
        'nombre' => 'Viaje Updated',
        'monto_objetivo' => 3000,
        'monto_actual' => 500,
        'fecha_limite' => now()->addYear()->format('Y-m-d'),
    ])->assertRedirect(route('presupuestos.index'));

    $this->assertDatabaseHas('metas_ahorro', [
        'id' => $meta->id,
        'nombre' => 'Viaje Updated',
        'monto_objetivo' => 3000.00,
        'monto_actual' => 500.00,
    ]);
});

it('elimina una meta de ahorro', function () {
    $meta = MetaAhorro::factory()->create(['user_id' => $this->user->id]);

    $this->delete(route('metas.destroy', $meta->id))
        ->assertRedirect(route('presupuestos.index'));

    $this->assertDatabaseMissing('metas_ahorro', ['id' => $meta->id]);
});

it('valida campos requeridos al crear meta', function () {
    $this->post(route('metas.store'), [])
        ->assertSessionHasErrors(['nombre', 'monto_objetivo']);
});

it('scope del usuario: solo ve sus propias metas', function () {
    $otherUser = User::factory()->create();
    MetaAhorro::factory()->create([
        'user_id' => $otherUser->id,
        'nombre' => 'Meta de otro',
    ]);

    $this->get(route('presupuestos.index'))
        ->assertDontSee('Meta de otro');
});
