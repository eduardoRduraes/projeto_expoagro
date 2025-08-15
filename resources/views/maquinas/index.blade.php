@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-tractor me-2"></i>Máquinas
                </h1>
                <p class="page-subtitle">Gerencie todas as máquinas do sistema</p>
            </div>
            <div>
                <a href="{{ route('maquinas.create') }}" class="btn-modern btn-primary">
                    <i class="fas fa-plus me-2"></i>Nova Máquina
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('maquinas.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Nome ou modelo...">
                </div>
                <div class="col-md-2">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select class="form-select" id="tipo" name="tipo">
                        <option value="">Todos</option>
                        <option value="trator" {{ request('tipo') == 'trator' ? 'selected' : '' }}>Trator</option>
                        <option value="implemento" {{ request('tipo') == 'implemento' ? 'selected' : '' }}>Implemento</option>
                        <option value="caminhao" {{ request('tipo') == 'caminhao' ? 'selected' : '' }}>Caminhão</option>
                        <option value="carro" {{ request('tipo') == 'carro' ? 'selected' : '' }}>Carro</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Todos</option>
                        <option value="livre" {{ request('status') == 'livre' ? 'selected' : '' }}>Livre</option>
                        <option value="em_servico" {{ request('status') == 'em_servico' ? 'selected' : '' }}>Em Serviço</option>
                        <option value="manutencao" {{ request('status') == 'manutencao' ? 'selected' : '' }}>Manutenção</option>
                        <option value="inativo" {{ request('status') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="ano" class="form-label">Ano</label>
                    <input type="number" class="form-control" id="ano" name="ano" 
                           value="{{ request('ano') }}" placeholder="2020" min="1990" max="{{ date('Y') + 1 }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-modern btn-primary">
                            <i class="fas fa-search me-2"></i>Filtrar
                        </button>
                        <a href="{{ route('maquinas.index') }}" class="btn-modern btn-secondary">
                            <i class="fas fa-times me-2"></i>Limpar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>Lista de Máquinas
                </h5>
                <span class="badge bg-primary">{{ $maquinas->total() }} máquinas</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" width="60">#</th>
                            <th>Nome</th>
                            <th>Modelo</th>
                            <th>Nº Série</th>
                            <th>Tipo</th>
                            <th class="text-center">Ano</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="200">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($maquinas as $maquina)
                            <tr>
                                <td class="text-center fw-medium">{{ $maquina->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            @switch($maquina->tipo)
                                                @case('trator')
                                                    <i class="fas fa-tractor text-primary"></i>
                                                    @break
                                                @case('caminhao')
                                                    <i class="fas fa-truck text-warning"></i>
                                                    @break
                                                @case('carro')
                                                    <i class="fas fa-car text-info"></i>
                                                    @break
                                                @default
                                                    <i class="fas fa-cogs text-secondary"></i>
                                            @endswitch
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $maquina->nome }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted">{{ preg_replace('/([a-zA-Z]+)(\d+)/', '$1-$2', $maquina->modelo) }}</td>
                                <td class="text-muted">{{ preg_replace('/(\d{3})([a-zA-Z]{3})(\d{3})/', '$1-$2-$3', $maquina->numero_serie) }}</td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ ucfirst($maquina->tipo) }}</span>
                                </td>
                                <td class="text-center">{{ $maquina->ano }}</td>
                                <td class="text-center">
                                    @switch($maquina->status)
                                        @case('livre')
                                            <span class="badge bg-success"><i class="fas fa-check me-1"></i>Livre</span>
                                            @break
                                        @case('em_servico')
                                            <span class="badge bg-warning"><i class="fas fa-play me-1"></i>Em Serviço</span>
                                            @break
                                        @case('inativo')
                                            <span class="badge bg-secondary"><i class="fas fa-pause me-1"></i>Inativo</span>
                                            @break
                                        @case('manutencao')
                                            <span class="badge bg-info"><i class="fas fa-wrench me-1"></i>Manutenção</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="text-center">
                                    <div class="btn-group-modern" role="group">
                                        <a href="{{ route('maquinas.show', $maquina->id) }}" 
                                           class="btn-action btn-info" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('maquinas.edit', $maquina->id) }}" 
                                           class="btn-action btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('maquinas.destroy', $maquina->id) }}" method="POST" 
                                              class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir esta máquina?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-danger" title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-search fa-2x mb-3"></i>
                                        <p class="mb-0">Nenhuma máquina encontrada</p>
                                        <small>Tente ajustar os filtros ou <a href="{{ route('maquinas.create') }}">cadastre uma nova máquina</a></small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(method_exists($maquinas, 'links'))
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Mostrando {{ $maquinas->firstItem() }} a {{ $maquinas->lastItem() }} 
                        de {{ $maquinas->total() }} resultados
                    </div>
                    <div>
                        {{ $maquinas->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
