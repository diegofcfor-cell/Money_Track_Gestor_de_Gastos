<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\MetaAhorroController;


Route::middleware(['auth'])->group(function () {

    Route::get('/movimientos', [MovimientoController::class, 'index'])->name('movimientos.index');
    Route::get('/movimientos/create', [MovimientoController::class, 'create'])->name('movimientos.create');
    Route::post('/movimientos', [MovimientoController::class, 'store'])->name('movimientos.store');
    Route::get('/movimientos/{id}/edit', [MovimientoController::class, 'edit'])->name('movimientos.edit');
    Route::put('/movimientos/{id}', [MovimientoController::class, 'update'])->name('movimientos.update');
    Route::delete('/movimientos/{id}', [MovimientoController::class, 'destroy'])->name('movimientos.destroy');

    Route::get('/reportes', [ReportesController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/pdf', [ReportesController::class, 'pdf'])->name('reportes.pdf');

    Route::get('/presupuestos', [PresupuestoController::class, 'index'])->name('presupuestos.index');
    Route::post('/presupuestos', [PresupuestoController::class, 'store'])->name('presupuestos.store');
    Route::put('/presupuestos/{id}', [PresupuestoController::class, 'update'])->name('presupuestos.update');
    Route::delete('/presupuestos/{id}', [PresupuestoController::class, 'destroy'])->name('presupuestos.destroy');

    Route::post('/metas-ahorro', [MetaAhorroController::class, 'store'])->name('metas.store');
    Route::put('/metas-ahorro/{id}', [MetaAhorroController::class, 'update'])->name('metas.update');
    Route::delete('/metas-ahorro/{id}', [MetaAhorroController::class, 'destroy'])->name('metas.destroy');

});

Route::get('/panel', [DashboardController::class, 'index'])
->middleware(['auth'])
->name('panel');

Route::get('/', function () {
    return redirect('/login');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
