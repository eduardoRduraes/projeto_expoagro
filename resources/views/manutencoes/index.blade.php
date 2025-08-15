@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Cabeçalho da Página -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-wrench me-2"></i>Manutenções
            </h1>
            <p class="mb-0 text-muted">Gerencie as manutenções das máquinas</p>
        </div>
        <a href="{{ route('manutencoes.create') }}" class="btn-modern btn-primary">
            <i class="fas fa-plus me-2"></i>Nova Manutenção
        </a>
    </div>

    <!-- Mensagem de Sucesso -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filtros -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Filtros
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('manutencoes.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Máquina ou descrição...">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="tipo" name="tipo">
                            <option value="">Todos</option>
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
                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn-modern btn-primary">
                                <i class="fas fa-search me-2"></i>Filtrar
                            </button>
                            <a href="{{ route('manutencoes.index') }}" class="btn-modern btn-secondary">
                                <i class="fas fa-times me-2"></i>Limpar
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Manutenções -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Lista de Manutenções
            </h6>
        </div>
        <div class="card-body">
            @if($manutencoes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">#</th>
                                <th><i class="fas fa-tractor me-1"></i>Máquina</th>
                                <th><i class="fas fa-file-alt me-1"></i>Descrição</th>
                                <th class="text-center"><i class="fas fa-tag me-1"></i>Tipo</th>
                                <th class="text-center"><i class="fas fa-dollar-sign me-1"></i>Custo</th>
                                <th class="text-center"><i class="fas fa-calendar me-1"></i>Data</th>
                                <th class="text-center"><i class="fas fa-user me-1"></i>Responsável</th>
                                <th class="text-center"><i class="fas fa-cog me-1"></i>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($manutencoes as $manutencao)
                                <tr>
                                    <td class="text-center">{{ $manutencao->id }}</td>
                                    <td>
                                        <strong>{{ $manutencao->maquina->nome }}</strong>
                                        @if($manutencao->maquina->modelo)
                                            <br><small class="text-muted">{{ $manutencao->maquina->modelo }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span title="{{ $manutencao->descricao }}">
                                            {{ Str::limit($manutencao->descricao, 50) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($manutencao->tipo == 'preventiva')
                                            <span class="badge bg-info"><i class="fas fa-shield-alt me-1"></i>Preventiva</span>
                                        @else
                                            <span class="badge bg-warning"><i class="fas fa-exclamation-triangle me-1"></i>Corretiva</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <strong class="text-success">R$ {{ number_format($manutencao->custo, 2, ',', '.') }}</strong>
                                    </td>
                                    <td class="text-center">
                                        {{ $manutencao->data_manutencao ? $manutencao->data_manutencao->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="text-center">
                                        {{ $manutencao->responsavel ?? '-' }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group-modern" role="group">
                            <a href="{{ route('manutencoes.show', $manutencao->id) }}" 
                               class="btn-action btn-info" title="Visualizar">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('manutencoes.edit', $manutencao->id) }}" 
                               class="btn-action btn-warning" title="Editar">
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

                <!-- Paginação -->
                @if($manutencoes->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $manutencoes->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-wrench fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhuma manutenção encontrada</h5>
                    <p class="text-muted">Não há manutenções cadastradas ou que atendam aos filtros aplicados.</p>
                    <a href="{{ route('manutencoes.create') }}" class="btn-modern btn-primary">
                        <i class="fas fa-plus me-2"></i>Cadastrar Primeira Manutenção
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
