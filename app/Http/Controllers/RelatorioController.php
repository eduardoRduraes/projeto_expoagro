<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use App\Models\Operador;
use App\Models\UsoMaquina;
use App\Models\Manutencao;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function index()
    {
        return view('relatorios.index');
    }

    public function usoMaquinas(Request $request)
    {
        $dataInicio = $request->get('data_inicio', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dataFim = $request->get('data_fim', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $maquinaId = $request->get('maquina_id');
        $operadorId = $request->get('operador_id');

        $query = UsoMaquina::with(['maquina', 'operador'])
            ->whereBetween('data', [$dataInicio, $dataFim]);

        if ($maquinaId) {
            $query->where('maquina_id', $maquinaId);
        }

        if ($operadorId) {
            $query->where('operador_id', $operadorId);
        }

        $usos = $query->orderBy('data', 'desc')->get();
        
        // Estatísticas do período
        $totalHoras = $usos->sum('total_horas');
        $totalUsos = $usos->count();
        $maquinasMaisUsadas = $usos->groupBy('maquina.nome')
            ->map(function ($grupo) {
                return [
                    'nome' => $grupo->first()->maquina->nome,
                    'total_horas' => $grupo->sum('total_horas'),
                    'total_usos' => $grupo->count()
                ];
            })
            ->sortByDesc('total_horas')
            ->take(5);

        $maquinas = Maquina::all();
        $operadores = Operador::all();

        return view('relatorios.uso-maquinas', compact(
            'usos', 'totalHoras', 'totalUsos', 'maquinasMaisUsadas',
            'maquinas', 'operadores', 'dataInicio', 'dataFim', 'maquinaId', 'operadorId'
        ));
    }

    public function custosManutencao(Request $request)
    {
        $dataInicio = $request->get('data_inicio', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dataFim = $request->get('data_fim', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $maquinaId = $request->get('maquina_id');
        $tipo = $request->get('tipo');

        $query = Manutencao::with('maquina')
            ->whereBetween('created_at', [$dataInicio . ' 00:00:00', $dataFim . ' 23:59:59']);

        if ($maquinaId) {
            $query->where('maquina_id', $maquinaId);
        }

        if ($tipo) {
            $query->where('tipo', $tipo);
        }

        $manutencoes = $query->orderBy('created_at', 'desc')->get();
        
        // Estatísticas do período
        $custoTotal = $manutencoes->sum('custo');
        $totalManutencoes = $manutencoes->count();
        $custoMedio = $totalManutencoes > 0 ? $custoTotal / $totalManutencoes : 0;
        
        $custosPorTipo = $manutencoes->groupBy('tipo')
            ->map(function ($grupo, $tipo) {
                return [
                    'tipo' => ucfirst($tipo),
                    'total' => $grupo->sum('custo'),
                    'quantidade' => $grupo->count()
                ];
            });

        $maquinasMaisCustosas = $manutencoes->groupBy('maquina.nome')
            ->map(function ($grupo) {
                return [
                    'nome' => $grupo->first()->maquina->nome,
                    'custo_total' => $grupo->sum('custo'),
                    'quantidade' => $grupo->count()
                ];
            })
            ->sortByDesc('custo_total')
            ->take(5);

        $maquinas = Maquina::all();

        return view('relatorios.custos-manutencao', compact(
            'manutencoes', 'custoTotal', 'totalManutencoes', 'custoMedio',
            'custosPorTipo', 'maquinasMaisCustosas', 'maquinas',
            'dataInicio', 'dataFim', 'maquinaId', 'tipo'
        ));
    }

    public function produtividade(Request $request)
    {
        $dataInicio = $request->get('data_inicio', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dataFim = $request->get('data_fim', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Produtividade por operador
        $produtividadeOperadores = UsoMaquina::with('operador')
            ->whereBetween('data', [$dataInicio, $dataFim])
            ->select('operador_id', DB::raw('SUM(total_horas) as total_horas'), DB::raw('COUNT(*) as total_usos'))
            ->groupBy('operador_id')
            ->orderByDesc('total_horas')
            ->get()
            ->map(function ($item) {
                return [
                    'operador' => $item->operador->nome,
                    'total_horas' => $item->total_horas,
                    'total_usos' => $item->total_usos,
                    'media_horas_por_uso' => $item->total_usos > 0 ? round($item->total_horas / $item->total_usos, 2) : 0
                ];
            });

        // Produtividade por máquina
        $produtividadeMaquinas = UsoMaquina::with('maquina')
            ->whereBetween('data', [$dataInicio, $dataFim])
            ->select('maquina_id', DB::raw('SUM(total_horas) as total_horas'), DB::raw('COUNT(*) as total_usos'))
            ->groupBy('maquina_id')
            ->orderByDesc('total_horas')
            ->get()
            ->map(function ($item) {
                return [
                    'maquina' => $item->maquina->nome,
                    'total_horas' => $item->total_horas,
                    'total_usos' => $item->total_usos,
                    'media_horas_por_uso' => $item->total_usos > 0 ? round($item->total_horas / $item->total_usos, 2) : 0
                ];
            });

        // Uso por dia da semana
        $usoPorDiaSemana = UsoMaquina::whereBetween('data', [$dataInicio, $dataFim])
            ->select(DB::raw('strftime("%w", data) as dia_semana'), DB::raw('SUM(total_horas) as total_horas'))
            ->groupBy('dia_semana')
            ->orderBy('dia_semana')
            ->get()
            ->mapWithKeys(function ($item) {
                $dias = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
                return [$dias[$item->dia_semana] => $item->total_horas];
            });

        return view('relatorios.produtividade', compact(
            'produtividadeOperadores', 'produtividadeMaquinas', 'usoPorDiaSemana',
            'dataInicio', 'dataFim'
        ));
    }
}