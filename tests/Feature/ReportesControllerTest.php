<?php

use App\Models\User;
use App\Models\Movimiento;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('carga la página de reportes', function () {
    Movimiento::factory()->count(3)->create(['user_id' => $this->user->id]);

    $this->get(route('reportes.index'))
        ->assertStatus(200)
        ->assertViewHas('movimientos');
});

it('filtra reportes por rango de fechas', function () {
    Movimiento::factory()->create([
        'user_id' => $this->user->id,
        'fecha' => '2025-01-01',
    ]);
    Movimiento::factory()->create([
        'user_id' => $this->user->id,
        'fecha' => '2025-06-15',
    ]);

    $this->get(route('reportes.index', ['desde' => '2025-06-01', 'hasta' => '2025-12-31']))
        ->assertStatus(200);
});

it('descarga PDF de reportes', function () {
    Movimiento::factory()->count(2)->create(['user_id' => $this->user->id]);

    $this->get(route('reportes.pdf'))
        ->assertStatus(200)
        ->assertHeader('Content-Type', 'application/pdf');
});
