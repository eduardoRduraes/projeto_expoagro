@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h1 class="page-title mb-1">
                    <i class="fas fa-chart-bar me-2"></i>Relatórios
                </h1>
                <p class="page-subtitle mb-0">Visualize relatórios e estatísticas do sistema</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Relatório de Uso de Máquinas -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Uso de Máquinas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Relatório detalhado do uso das máquinas por período
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('relatorios.uso-maquinas') }}" class="btn-modern btn-primary btn-sm">
                                    <i class="fas fa-chart-line"></i> Visualizar Relatório
                                </a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tractor fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Relatório de Custos de Manutenção -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Custos de Manutenção
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Análise de custos e tipos de manutenção
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('relatorios.custos-manutencao') }}" class="btn-modern btn-success btn-sm">
                                    <i class="fas fa-dollar-sign"></i> Visualizar Relatório
                                </a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tools fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Relatório de Produtividade -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Produtividade
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Análise de produtividade por operador e máquina
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('relatorios.produtividade') }}" class="btn-modern btn-info btn-sm">
                                    <i class="fas fa-chart-bar"></i> Visualizar Relatório
                                </a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-pie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Seção de Ações Rápidas -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ações Rápidas</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('dashboard') }}" class="btn-modern btn-primary btn-block">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('maquinas.index') }}" class="btn-modern btn-secondary btn-block">
                                <i class="fas fa-tractor"></i> Máquinas
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('operadores.index') }}" class="btn-modern btn-secondary btn-block">
                                <i class="fas fa-users"></i> Operadores
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('usomaquinas.index') }}" class="btn-modern btn-secondary btn-block">
                                <i class="fas fa-clock"></i> Uso de Máquinas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection