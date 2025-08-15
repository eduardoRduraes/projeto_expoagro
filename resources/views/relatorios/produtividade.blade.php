@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Relatório de Produtividade</h1>
                <a href="{{ route('relatorios.index') }}" class="btn-modern btn-secondary">
                    <i class="fas fa-arrow-left"></i> Voltar aos Relatórios
                </a>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('relatorios.produtividade') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label for="data_inicio">Data Início:</label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio" value="{{ $dataInicio }}">
                    </div>
                    <div class="col-md-4">
                        <label for="data_fim">Data Fim:</label>
                        <input type="date" class="form-control" id="data_fim" name="data_fim" value="{{ $dataFim }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn-modern btn-primary mr-2">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                        <a href="{{ route('relatorios.produtividade') }}" class="btn-modern btn-secondary">
                            <i class="fas fa-times"></i> Limpar Filtros
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Período Selecionado -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <strong>Período de Análise:</strong> {{ \Carbon\Carbon::parse($dataInicio)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($dataFim)->format('d/m/Y') }}
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Produtividade por Operador -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Produtividade por Operador</h6>
                </div>
                <div class="card-body">
                    @forelse($produtividadeOperadores as $operador)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>{{ $operador['operador'] }}</strong>
                                <span class="badge badge-primary">{{ number_format($operador['total_horas'], 2) }}h</span>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Total de Usos:</small>
                                    <div class="font-weight-bold">{{ $operador['total_usos'] }}</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Média por Uso:</small>
                                    <div class="font-weight-bold">{{ $operador['media_horas_por_uso'] }}h</div>
                                </div>
                            </div>
                            @if(!$loop->last)
                                <hr class="mt-3">
                            @endif
                        </div>
                    @empty
                        <p class="text-muted">Nenhum dado de produtividade encontrado para o período selecionado.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Produtividade por Máquina -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Produtividade por Máquina</h6>
                </div>
                <div class="card-body">
                    @forelse($produtividadeMaquinas as $maquina)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>{{ $maquina['maquina'] }}</strong>
                                <span class="badge badge-success">{{ number_format($maquina['total_horas'], 2) }}h</span>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Total de Usos:</small>
                                    <div class="font-weight-bold">{{ $maquina['total_usos'] }}</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Média por Uso:</small>
                                    <div class="font-weight-bold">{{ $maquina['media_horas_por_uso'] }}h</div>
                                </div>
                            </div>
                            @if(!$loop->last)
                                <hr class="mt-3">
                            @endif
                        </div>
                    @empty
                        <p class="text-muted">Nenhum dado de produtividade encontrado para o período selecionado.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Uso por Dia da Semana -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Distribuição de Uso por Dia da Semana</h6>
                </div>
                <div class="card-body">
                    @if($usoPorDiaSemana->count() > 0)
                        <div class="row">
                            @foreach($usoPorDiaSemana as $dia => $horas)
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="card border-left-info">
                                        <div class="card-body py-3">
                                            <div class="text-center">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    {{ $dia }}
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ number_format($horas, 2) }}h
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Nenhum dado de uso por dia da semana encontrado para o período selecionado.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Resumo Geral -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Resumo Geral do Período</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="text-center">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total de Operadores Ativos
                                </div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">
                                    {{ $produtividadeOperadores->count() }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="text-center">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total de Máquinas Utilizadas
                                </div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">
                                    {{ $produtividadeMaquinas->count() }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="text-center">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total de Horas Trabalhadas
                                </div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($produtividadeOperadores->sum('total_horas'), 2) }}h
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="text-center">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total de Operações
                                </div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">
                                    {{ $produtividadeOperadores->sum('total_usos') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection