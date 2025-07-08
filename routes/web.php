<?php

use App\Http\Controllers\MaquinaController;
use App\Http\Controllers\OperadorController;
use App\Http\Controllers\UsoMaquinaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('maquinas', MaquinaController::class)->parameters(['maquinas' => 'maquina']);
Route::resource('operadores', OperadorController::class)->parameters(['operadores' => 'operador']);
Route::resource('usomaquinas', UsoMaquinaController::class)->parameters(['usomaquina' => 'usomaquinas']);
