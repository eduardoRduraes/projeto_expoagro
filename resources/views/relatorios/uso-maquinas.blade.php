@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Relatório de Uso de Máquinas</h1>
                <a href="{{ route('relatorios.index') }}" class="btn-modern btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Voltar aos Relatórios
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
            <form method="GET" action="{{ route('relatorios.uso-maquinas') }}">
                <div class="row">
                    <div class="col-md-3">
                        <label for="data_inicio">Data Início:</label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio" value="{{ $dataInicio }}">
                    </div>
                    <div class="col-md-3">
                        <label for="data_fim">Data Fim:</label>
                        <input type="date" class="form-control" id="data_fim" name="data_fim" value="{{ $dataFim }}">
                    </div>
                    <div class="col-md-3">
                        <label for="maquina_id">Máquina:</label>
                        <select class="form-control" id="maquina_id" name="maquina_id">
                            <option value="">Todas as máquinas</option>
                            @foreach($maquinas as $maquina)
                                <option value="{{ $maquina->id }}" {{ $maquinaId == $maquina->id ? 'selected' : '' }}>
                                    {{ $maquina->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="operador_id">Operador:</label>
                        <select class="form-control" id="operador_id" name="operador_id">
                            <option value="">Todos os operadores</option>
                            @foreach($operadores as $operador)
                                <option value="{{ $operador->id }}" {{ $operadorId == $operador->id ? 'selected' : '' }}>
                                    {{ $operador->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn-modern btn-primary">
                                <i class="fas fa-search me-2"></i>Filtrar
                            </button>
                            <a href="{{ route('relatorios.uso-maquinas') }}" class="btn-modern btn-secondary">
                                <i class="fas fa-times me-2"></i>Limpar Filtros
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Estatísticas Resumo -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total de Horas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalHoras, 2) }}h</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total de Usos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsos }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Média por Uso
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalUsos > 0 ? number_format($totalHoras / $totalUsos, 2) : 0 }}h
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calculator fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Período
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                {{ \Carbon\Carbon::parse($dataInicio)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($dataFim)->format('d/m/Y') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Máquinas Mais Usadas -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top 5 Máquinas Mais Usadas</h6>
                </div>
                <div class="card-body">
                    @forelse($maquinasMaisUsadas as $maquina)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <strong>{{ $maquina['nome'] }}</strong><br>
                                <small class="text-muted">{{ $maquina['total_usos'] }} usos</small>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-primary">{{ number_format($maquina['total_horas'], 2) }}h</span>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @empty
                        <p class="text-muted">Nenhum dado encontrado para o período selecionado.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Lista Detalhada -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detalhes dos Usos</h6>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @forelse($usos->take(10) as $uso)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <strong>{{ $uso->maquina->nome }}</strong><br>
                                <small class="text-muted">
                                    {{ $uso->operador->nome }} - {{ \Carbon\Carbon::parse($uso->data)->format('d/m/Y') }}
                                </small><br>
                                @if($uso->tarefa)
                                    <small class="text-info">{{ $uso->tarefa }}</small>
                                @endif
                            </div>
                            <div class="text-right">
                                <span class="badge badge-success">{{ number_format($uso->total_horas, 2) }}h</span><br>
                                <small class="text-muted">{{ $uso->hora_inicio }} - {{ $uso->hora_fim }}</small>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @empty
                        <p class="text-muted">Nenhum uso encontrado para o período selecionado.</p>
                    @endforelse
                    
                    @if($usos->count() > 10)
                        <div class="text-center mt-3">
                            <small class="text-muted">Mostrando 10 de {{ $usos->count() }} registros</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela Completa -->
    @if($usos->count() > 0)
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Todos os Registros</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Máquina</th>
                            <th>Operador</th>
                            <th>Início</th>
                            <th>Fim</th>
                            <th>Total Horas</th>
                            <th>Tarefa</th>
                            <th>Observação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usos as $uso)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($uso->data)->format('d/m/Y') }}</td>
                                <td>{{ $uso->maquina->nome }}</td>
                                <td>{{ $uso->operador->nome }}</td>
                                <td>{{ $uso->hora_inicio }}</td>
                                <td>{{ $uso->hora_fim }}</td>
                                <td>{{ number_format($uso->total_horas, 2) }}h</td>
                                <td>{{ $uso->tarefa ?? '-' }}</td>
                                <td>{{ $uso->observacao ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection