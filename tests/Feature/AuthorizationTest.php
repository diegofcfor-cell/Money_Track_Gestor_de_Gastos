<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('redirige a invitados al login', function () {
    $this->get(route('panel'))->assertRedirect(route('login'));
    $this->get(route('movimientos.index'))->assertRedirect(route('login'));
    $this->get(route('presupuestos.index'))->assertRedirect(route('login'));
    $this->get(route('reportes.index'))->assertRedirect(route('login'));
});

it('aisla datos entre usuarios', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $movA = \App\Models\Movimiento::factory()->create([
        'user_id' => $userA->id,
        'monto' => 100.50,
    ]);

    $this->actingAs($userB);
    $this->get(route('movimientos.index'))
        ->assertDontSee(number_format($movA->monto, 2));
});
