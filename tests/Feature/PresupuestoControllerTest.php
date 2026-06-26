<?php

use App\Models\User;
use App\Models\Presupuesto;
use App\Models\Categoria;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('lista presupuestos del mes actual', function () {
    Presupuesto::factory()->create([
        'user_id' => $this->user->id,
        'mes' => now()->month,
        'año' => now()->year,
    ]);

    $this->get(route('presupuestos.index'))
        ->assertStatus(200)
        ->assertViewHas('presupuestos');
});

it('crea un presupuesto', function () {
    $categoria = Categoria::factory()->create();

    $this->post(route('presupuestos.store'), [
        'categoria_id' => $categoria->id,
        'limite_mensual' => 1500,
    ])->assertRedirect(route('presupuestos.index'));

    $this->assertDatabaseHas('presupuestos', [
        'user_id' => $this->user->id,
        'categoria_id' => $categoria->id,
        'limite_mensual' => 1500.00,
        'mes' => now()->month,
        'año' => now()->year,
    ]);
});

it('actualiza un presupuesto existente', function () {
    $presupuesto = Presupuesto::factory()->create([
        'user_id' => $this->user->id,
        'limite_mensual' => 1000,
    ]);

    $this->put(route('presupuestos.update', $presupuesto->id), [
        'limite_mensual' => 2000,
    ])->assertRedirect(route('presupuestos.index'));

    $this->assertDatabaseHas('presupuestos', [
        'id' => $presupuesto->id,
        'limite_mensual' => 2000.00,
    ]);
});

it('elimina un presupuesto', function () {
    $presupuesto = Presupuesto::factory()->create(['user_id' => $this->user->id]);

    $this->delete(route('presupuestos.destroy', $presupuesto->id))
        ->assertRedirect(route('presupuestos.index'));

    $this->assertDatabaseMissing('presupuestos', ['id' => $presupuesto->id]);
});

it('unique constraint: mismo usuario, categoria, mes y año hace updateOrCreate', function () {
    $categoria = Categoria::factory()->create();

    $this->post(route('presupuestos.store'), [
        'categoria_id' => $categoria->id,
        'limite_mensual' => 1000,
    ]);

    $this->post(route('presupuestos.store'), [
        'categoria_id' => $categoria->id,
        'limite_mensual' => 2000,
    ]);

    $presupuestos = Presupuesto::where('user_id', $this->user->id)
        ->where('categoria_id', $categoria->id)
        ->where('mes', now()->month)
        ->where('año', now()->year)
        ->get();

    expect($presupuestos)->toHaveCount(1);
    expect((float) $presupuestos->first()->limite_mensual)->toEqual(2000.00);
});

it('scope del presupuesto: solo del mes y año actual', function () {
    Presupuesto::factory()->create([
        'user_id' => $this->user->id,
        'mes' => 1,
        'año' => 2020,
    ]);

    $this->get(route('presupuestos.index'))
        ->assertStatus(200)
        ->assertViewHas('presupuestos', function ($presupuestos) {
            return $presupuestos->isEmpty();
        });
});
