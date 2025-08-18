<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaquinaController;
use App\Http\Controllers\ManutencaoController;
use App\Http\Controllers\OperadorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\UsoMaquinaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('maquinas', MaquinaController::class)->parameters(['maquinas' => 'maquina']);
    Route::resource('operadores', OperadorController::class)->parameters(['operadores' => 'operador']);
    Route::resource('usomaquinas', UsoMaquinaController::class)->parameters(['usomaquina' => 'usomaquinas']);
    Route::resource('manutencoes', ManutencaoController::class)->parameters(['manutencoes' => 'manutencao']);
    
    // Rotas de relatórios
    Route::prefix('relatorios')->name('relatorios.')->group(function () {
        Route::get('/', [RelatorioController::class, 'index'])->name('index');
        Route::get('/uso-maquinas', [RelatorioController::class, 'usoMaquinas'])->name('uso-maquinas');
        Route::get('/custos-manutencao', [RelatorioController::class, 'custosManutencao'])->name('custos-manutencao');
        Route::get('/produtividade', [RelatorioController::class, 'produtividade'])->name('produtividade');
        
        // Rotas de exportação PDF
        Route::get('/uso-maquinas/pdf', [RelatorioController::class, 'exportarUsoMaquinasPdf'])->name('uso-maquinas.pdf');
        Route::get('/custos-manutencao/pdf', [RelatorioController::class, 'exportarCustosManutencaoPdf'])->name('custos-manutencao.pdf');
        Route::get('/produtividade/pdf', [RelatorioController::class, 'exportarProdutividadePdf'])->name('produtividade.pdf');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
