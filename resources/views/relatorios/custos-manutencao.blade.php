@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Relatório de Custos de Manutenção</h1>
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
            <form method="GET" action="{{ route('relatorios.custos-manutencao') }}">
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
                        <label for="tipo">Tipo de Manutenção:</label>
                        <select class="form-control" id="tipo" name="tipo">
                            <option value="">Todos os tipos</option>
                            <option value="preventiva" {{ $tipo == 'preventiva' ? 'selected' : '' }}>Preventiva</option>
                            <option value="corretiva" {{ $tipo == 'corretiva' ? 'selected' : '' }}>Corretiva</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn-modern btn-primary">
                                <i class="fas fa-search me-2"></i>Filtrar
                            </button>
                            <a href="{{ route('relatorios.custos-manutencao') }}" class="btn-modern btn-secondary">
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
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Custo Total
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">R$ {{ number_format($custoTotal, 2, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total de Manutenções
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalManutencoes }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tools fa-2x text-gray-300"></i>
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
                                Custo Médio
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">R$ {{ number_format($custoMedio, 2, ',', '.') }}</div>
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
        <!-- Custos por Tipo -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Custos por Tipo de Manutenção</h6>
                </div>
                <div class="card-body">
                    @forelse($custosPorTipo as $tipoCusto)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <strong>{{ $tipoCusto['tipo'] }}</strong><br>
                                <small class="text-muted">{{ $tipoCusto['quantidade'] }} manutenções</small>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-success">R$ {{ number_format($tipoCusto['total'], 2, ',', '.') }}</span>
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

        <!-- Máquinas Mais Custosas -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top 5 Máquinas Mais Custosas</h6>
                </div>
                <div class="card-body">
                    @forelse($maquinasMaisCustosas as $maquina)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <strong>{{ $maquina['nome'] }}</strong><br>
                                <small class="text-muted">{{ $maquina['quantidade'] }} manutenções</small>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-danger">R$ {{ number_format($maquina['custo_total'], 2, ',', '.') }}</span>
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
    </div>

    <!-- Tabela Completa -->
    @if($manutencoes->count() > 0)
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Todas as Manutenções</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Máquina</th>
                            <th>Tipo</th>
                            <th>Descrição</th>
                            <th>Custo</th>
                            <th>Data Manutenção</th>
                            <th>Responsável</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($manutencoes as $manutencao)
                            <tr>
                                <td>{{ $manutencao->created_at->format('d/m/Y') }}</td>
                                <td>{{ $manutencao->maquina->nome }}</td>
                                <td>
                                    <span class="badge badge-{{ $manutencao->tipo == 'preventiva' ? 'info' : 'warning' }}">
                                        {{ ucfirst($manutencao->tipo) }}
                                    </span>
                                </td>
                                <td>{{ $manutencao->descricao ?? '-' }}</td>
                                <td>R$ {{ number_format($manutencao->custo, 2, ',', '.') }}</td>
                                <td>{{ $manutencao->data_manutencao ? $manutencao->data_manutencao->format('d/m/Y') : '-' }}</td>
                                <td>{{ $manutencao->responsavel ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-{{ $manutencao->status == 'livre' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($manutencao->status) }}
                                    </span>
                                </td>
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