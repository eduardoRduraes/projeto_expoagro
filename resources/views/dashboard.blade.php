@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('maquinas.create') }}" class="btn-modern btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>Nova Máquina
            </a>
            <a href="{{ route('operadores.create') }}" class="btn-modern btn-success btn-sm">
                <i class="fas fa-plus me-1"></i>Novo Operador
            </a>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Estatísticas Gerais -->
    <div class="row mb-4">
        <!-- Total de Máquinas -->
        <div class="col-md-3 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <div class="ms-3">
                            <p class="stat-label">Total de Máquinas</p>
                            <h3 class="stat-value">{{ $totalMaquinas }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Máquinas Ativas -->
        <div class="col-md-3 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success">
                            <i class="fas fa-tractor"></i>
                        </div>
                        <div class="ms-3">
                            <p class="stat-label">Máquinas em Serviço</p>
                            <h3 class="stat-value">{{ $maquinasAtivas }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total de Operadores -->
        <div class="col-md-3 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="ms-3">
                            <p class="stat-label">Total de Operadores</p>
                            <h3 class="stat-value">{{ $totalOperadores }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Manutenções Pendentes -->
        <div class="col-md-3 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div class="ms-3">
                            <p class="stat-label">Manutenções Pendentes</p>
                            <h3 class="stat-value">{{ $manutencoesPendentes }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos e Informações Adicionais -->
    <div class="row mb-4">
        <!-- Uso de Máquinas Recente -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i>Uso de Máquinas Recente
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($usosRecentes as $uso)
                        <div class="d-flex justify-content-between align-items-center p-3 mb-2 bg-light rounded">
                            <div>
                                <h6 class="mb-1">{{ $uso->maquina->nome }}</h6>
                                <small class="text-muted">Operador: {{ $uso->operador->nome }}</small><br>
                                <small class="text-muted">{{ $uso->data->format('d/m/Y') }} - {{ $uso->total_horas }}h</small>
                            </div>
                            <div>
                                <span class="badge bg-success">
                                    {{ $uso->tarefa ?? 'Sem tarefa' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">Nenhum uso registrado recentemente</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Status das Máquinas -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Status das Máquinas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-medium">Livres</span>
                        <span class="badge bg-success">
                            {{ $statusMaquinas['livre'] ?? 0 }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-medium">Em Serviço</span>
                        <span class="badge bg-primary">
                            {{ $statusMaquinas['em_servico'] ?? 0 }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-medium">Em Manutenção</span>
                        <span class="badge bg-warning">
                            {{ $statusMaquinas['manutencao'] ?? 0 }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-medium">Inativas</span>
                        <span class="badge bg-danger">
                            {{ $statusMaquinas['inativo'] ?? 0 }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ações Rápidas -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-rocket me-2"></i>Ações Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('usomaquinas.create') }}" class="btn-modern btn-primary w-100">
                                <i class="fas fa-clipboard-list me-2"></i>Registrar Uso
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('manutencoes.create') }}" class="btn-modern btn-warning w-100">
                                <i class="fas fa-tools me-2"></i>Nova Manutenção
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('relatorios.index') }}" class="btn-modern btn-info w-100">
                                <i class="fas fa-file-chart-line me-2"></i>Relatórios
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('maquinas.index') }}" class="btn-modern btn-secondary w-100">
                                <i class="fas fa-tractor me-2"></i>Ver Máquinas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
