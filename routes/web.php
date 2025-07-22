<?php

use App\Http\Controllers\MaquinaController;
use App\Http\Controllers\ManutencaoController;
use App\Http\Controllers\OperadorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsoMaquinaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('maquinas', MaquinaController::class)->parameters(['maquinas' => 'maquina']);
    Route::resource('operadores', OperadorController::class)->parameters(['operadores' => 'operador']);
    Route::resource('usomaquinas', UsoMaquinaController::class)->parameters(['usomaquina' => 'usomaquinas']);
    Route::resource('manutencoes', ManutencaoController::class)->parameters(['manutencao' => 'manutencoes']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
