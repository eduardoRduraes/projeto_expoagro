@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h1 class="page-title mb-1">
                    <i class="fas fa-wrench me-2"></i>Manutenções
                </h1>
                <p class="page-subtitle mb-0">Gerencie as manutenções das máquinas</p>
            </div>
            <div class="w-100 w-md-auto">
                <a href="{{ route('manutencoes.create') }}" class="btn-modern btn-primary w-100 w-md-auto">
                    <i class="fas fa-plus me-2"></i>Nova Manutenção
                </a>
            </div>
        </div>
    </div>

    {{-- Mensagem de Sucesso --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header d-md-none">
            <h6 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('manutencoes.index') }}">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="search" class="form-label">Buscar por Máquina ou Descrição</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Digite a máquina ou descrição...">
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="tipo" name="tipo">
                            <option value="">Todos os Tipos</option>
                            <option value="preventiva" {{ request('tipo') == 'preventiva' ? 'selected' : '' }}>Preventiva</option>
                            <option value="corretiva" {{ request('tipo') == 'corretiva' ? 'selected' : '' }}>Corretiva</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="data_inicio" class="form-label">Data Início</label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                               value="{{ request('data_inicio') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="data_fim" class="form-label">Data Fim</label>
                        <input type="date" class="form-control" id="data_fim" name="data_fim" 
                               value="{{ request('data_fim') }}">
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <div class="btn-group w-100" role="group">
                            <button type="submit" class="btn-modern btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('manutencoes.index') }}" class="btn-modern btn-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Card com Tabela --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table me-2"></i>
                Lista de Manutenções
                <span class="badge bg-primary ms-2">{{ $manutencoes->total() }}</span>
            </h6>
        </div>
        <div class="card-body">
            @if($manutencoes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center col-id">
                                    <i class="fas fa-hashtag"></i> ID
                                </th>
                                <th>
                                    <i class="fas fa-tractor"></i> Máquina
                                </th>
                                <th style="width: 200px;"> <!-- Diminuído de sem limite para 200px -->
                                    <i class="fas fa-file-alt"></i> Descrição
                                </th>
                                <th class="text-center" style="width: 100px;">
                                    <i class="fas fa-tag"></i> Tipo
                                </th>
                                <th class="text-center" style="width: 100px;">
                                    <i class="fas fa-dollar-sign"></i> Custo
                                </th>
                                <th class="text-center" style="width: 100px;">
                                    <i class="fas fa-calendar"></i> Data
                                </th>
                                <th class="text-center" style="width: 180px;"> <!-- Aumentado de 120px para 180px -->
                                    <i class="fas fa-user"></i> Responsável
                                </th>
                                <th class="text-center" style="width: 160px;">
                                    <i class="fas fa-cogs"></i> Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($manutencoes as $manutencao)
                                <tr>
                                    <td class="text-center table-index">#{{ $manutencao->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-tractor text-muted"></i>
                                            </div>
                                            <div>
                                                <span class="fw-medium">{{ $manutencao->maquina->nome }}</span>
                                                @if($manutencao->maquina->modelo)
                                                    <br><small class="text-muted">{{ $manutencao->maquina->modelo }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span title="{{ $manutencao->descricao }}">
                                            {{ Str::limit($manutencao->descricao, 50) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($manutencao->tipo == 'preventiva')
                                            <span class="badge bg-info">
                                                <i class="fas fa-shield-alt me-1"></i>Preventiva
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-exclamation-triangle me-1"></i>Corretiva
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="text-success fw-medium">
                                            R$ {{ number_format($manutencao->custo, 2, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($manutencao->data_manutencao)
                                            <span class="text-muted">
                                                {{ $manutencao->data_manutencao->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="text-muted">{{ $manutencao->responsavel ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group-modern" role="group">
                                            <a href="{{ route('manutencoes.show', $manutencao->id) }}" 
                                               class="btn-action btn-info" 
                                               title="Visualizar">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('manutencoes.edit', $manutencao->id) }}" 
                                               class="btn-action btn-warning" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('manutencoes.destroy', $manutencao->id) }}" 
                                                  method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Tem certeza que deseja excluir esta manutenção?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-danger" title="Excluir">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Paginação --}}
                @if(method_exists($manutencoes, 'links'))
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Mostrando {{ $manutencoes->firstItem() }} a {{ $manutencoes->lastItem() }} 
                            de {{ $manutencoes->total() }} resultados
                        </div>
                        <div>
                            {{ $manutencoes->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-wrench fa-3x text-muted"></i>
                    </div>
                    <h5 class="text-muted">Nenhuma manutenção encontrada</h5>
                    <p class="text-muted mb-4">Não há manutenções cadastradas que correspondam aos filtros aplicados.</p>
                    <a href="{{ route('manutencoes.create') }}" class="btn-modern btn-primary">
                        <i class="fas fa-plus me-2"></i>Cadastrar Primeira Manutenção
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
