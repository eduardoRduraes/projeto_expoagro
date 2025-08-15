<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use App\Models\Operador;
use App\Models\UsoMaquina;
use App\Models\Manutencao;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Estatísticas gerais
        $totalMaquinas = Maquina::count();
        $maquinasAtivas = Maquina::where('status', 'em_servico')->count();
        $totalOperadores = Operador::count();
        $totalUsos = UsoMaquina::count();
        $totalManutencoes = Manutencao::count();
        $manutencoesPendentes = Manutencao::where('status', 'manutencao')->count();

        // Status das máquinas
        $statusMaquinas = Maquina::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Usos recentes (últimos 5)
        $usosRecentes = UsoMaquina::with(['maquina', 'operador'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalMaquinas',
            'maquinasAtivas',
            'totalOperadores',
            'totalUsos',
            'totalManutencoes',
            'manutencoesPendentes',
            'statusMaquinas',
            'usosRecentes'
        ));
    }
}