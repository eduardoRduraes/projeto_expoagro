@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
        <h1 class="mb-0"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h1>
        <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
            <a href="{{ route('maquinas.create') }}" class="btn-modern btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i><span class="d-none d-sm-inline">Nova </span>Máquina
            </a>
            <a href="{{ route('operadores.create') }}" class="btn-modern btn-success btn-sm">
                <i class="fas fa-plus me-1"></i><span class="d-none d-sm-inline">Novo </span>Operador
            </a>
        </div>
    </div>
</div>

<div class="container-fluid px-2"> <!-- Padding mínimo -->
    <!-- Estatísticas Gerais -->
    <div class="row mb-3 g-2"> <!-- Gap reduzido -->
        <!-- Total de Máquinas -->
        <div class="col-sm-6 col-xl-3 mb-2">
            <div class="card stat-card h-100">
                <div class="card-body p-2"> <!-- Padding reduzido -->
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary flex-shrink-0">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <div class="ms-2 text-truncate"> <!-- Margem reduzida -->
                            <p class="stat-label mb-1">Total de Máquinas</p>
                            <h3 class="stat-value mb-0">{{ $totalMaquinas }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Máquinas Ativas -->
        <div class="col-sm-6 col-xl-3 mb-2">
            <div class="card stat-card h-100">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success flex-shrink-0">
                            <i class="fas fa-tractor"></i>
                        </div>
                        <div class="ms-2 text-truncate">
                            <p class="stat-label mb-1">Máquinas em Serviço</p>
                            <h3 class="stat-value mb-0">{{ $maquinasAtivas }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total de Operadores -->
        <div class="col-sm-6 col-xl-3 mb-2">
            <div class="card stat-card h-100">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info flex-shrink-0">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="ms-2 text-truncate">
                            <p class="stat-label mb-1">Total de Operadores</p>
                            <h3 class="stat-value mb-0">{{ $totalOperadores }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Manutenções Pendentes -->
        <div class="col-sm-6 col-xl-3 mb-2">
            <div class="card stat-card h-100">
                <div class="card-body p-2">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning flex-shrink-0">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div class="ms-2 text-truncate">
                            <p class="stat-label mb-1">Manutenções Pendentes</p>
                            <h3 class="stat-value mb-0">{{ $manutencoesPendentes }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos e Informações Adicionais -->
    <div class="row mb-3 g-2">
        <!-- Uso de Máquinas Recente -->
        <div class="col-lg-6 mb-2">
            <div class="card h-100">
                <div class="card-header p-2">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i><span class="d-none d-sm-inline">Uso de Máquinas </span>Recente
                    </h5>
                </div>
                <div class="card-body p-2">
                    @forelse($usosRecentes as $uso)
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center p-2 mb-1 bg-light rounded gap-1">
                            <div class="flex-grow-1">
                                <h6 class="mb-1 text-truncate">{{ $uso->maquina->nome }}</h6>
                                <small class="text-muted d-block">Operador: {{ $uso->operador->nome }}</small>
                                <small class="text-muted">{{ $uso->data->format('d/m/Y') }} - {{ $uso->total_horas }}h</small>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="badge bg-success">
                                    {{ $uso->tarefa ?? 'Sem tarefa' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center py-2">Nenhum uso registrado recentemente</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Status das Máquinas -->
        <div class="col-lg-6 mb-2">
            <div class="card">
                <div class="card-header p-2">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Status das Máquinas
                    </h5>
                </div>
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-medium">Livres</span>
                        <span class="badge bg-success">
                            {{ $statusMaquinas['livre'] ?? 0 }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-medium">Em Serviço</span>
                        <span class="badge bg-primary">
                            {{ $statusMaquinas['em_servico'] ?? 0 }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-1">
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
    <div class="row g-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header p-2">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-rocket me-2"></i>Ações Rápidas
                    </h5>
                </div>
                <div class="card-body p-2">
                    <div class="row g-1"> <!-- Gap mínimo -->
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
