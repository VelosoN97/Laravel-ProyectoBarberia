<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard-admin', [
        DashboardController::class,
        'index'
    ])->name('dashboard.admin');

    Route::resource('servicios', ServicioController::class);
    Route::resource('horarios', HorarioController::class);
});

Route::middleware('auth')->group(function () {
    Route::resource('reservas', ReservaController::class);
    Route::patch(
        '/reservas/{reserva}/estado',
        [ReservaController::class, 'cambiarEstado']
    )->name('reservas.estado');
    Route::get('/calendario', [ReservaController::class, 'calendario'])
    ->name('reservas.calendario');
    Route::get('/horarios-disponibles', [ReservaController::class, 'horariosDisponibles'])
    ->name('reservas.horarios');
    Route::get('/reservas-pdf', [ReservaController::class, 'exportarPDF'])
    ->name('reservas.pdf');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
