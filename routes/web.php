<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovimientoController;


Route::middleware(['auth'])->group(function () {

    Route::get('/movimientos/create', [MovimientoController::class, 'create'])->name('movimientos.create');
    Route::post('/movimientos', [MovimientoController::class, 'store'])->name('movimientos.store');

    Route::get('/movimientos/{id}/edit', [MovimientoController::class, 'edit'])->name('movimientos.edit');
    Route::put('/movimientos/{id}', [MovimientoController::class, 'update'])->name('movimientos.update');

    Route::delete('/movimientos/{id}', [MovimientoController::class, 'destroy'])->name('movimientos.destroy');

});

Route::get('/dashboard', [DashboardController::class, 'index'])
->middleware(['auth'])
->name('dashboard'); // 👈 CLAVE

Route::get('/movimientos/pdf', [DashboardController::class, 'pdf'])
    ->middleware(['auth'])
    ->name('movimientos.pdf');

Route::get('/', function () {
    return redirect('/login');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
