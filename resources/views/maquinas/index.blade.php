@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h1 class="page-title mb-1">
                    <i class="fas fa-tractor me-2"></i>Máquinas
                </h1>
                <p class="page-subtitle mb-0">Gerencie todas as máquinas do sistema</p>
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('maquinas.create') }}" class="btn-modern btn-primary" style="padding: 0.25rem 1rem; font-size: 0.85rem;">
                    <i class="fas fa-plus me-2"></i>Nova Máquina
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
            <form method="GET" action="{{ route('maquinas.index') }}">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="search" class="form-label">Buscar por Nome ou Modelo</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Digite o nome ou modelo...">
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="tipo" name="tipo">
                            <option value="">Todos os Tipos</option>
                            <option value="trator" {{ request('tipo') == 'trator' ? 'selected' : '' }}>Trator</option>
                            <option value="implemento" {{ request('tipo') == 'implemento' ? 'selected' : '' }}>Implemento</option>
                            <option value="caminhao" {{ request('tipo') == 'caminhao' ? 'selected' : '' }}>Caminhão</option>
                            <option value="carro" {{ request('tipo') == 'carro' ? 'selected' : '' }}>Carro</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Todos os Status</option>
                            <option value="livre" {{ request('status') == 'livre' ? 'selected' : '' }}>Livre</option>
                            <option value="em_servico" {{ request('status') == 'em_servico' ? 'selected' : '' }}>Em Serviço</option>
                            <option value="manutencao" {{ request('status') == 'manutencao' ? 'selected' : '' }}>Manutenção</option>
                            <option value="inativo" {{ request('status') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="ano" class="form-label">Ano</label>
                        <input type="number" class="form-control" id="ano" name="ano" 
                               value="{{ request('ano') }}" placeholder="2020" min="1990" max="{{ date('Y') + 1 }}">
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <div class="btn-group w-100" role="group">
                            <button type="submit" class="btn-modern btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('maquinas.index') }}" class="btn-modern btn-secondary">
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
                Lista de Máquinas
                <span class="badge bg-primary ms-2">{{ $maquinas->total() }}</span>
            </h6>
        </div>
        <div class="card-body">
            @if($maquinas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center col-id">
                                    <i class="fas fa-hashtag"></i> ID
                                </th>
                                <th>
                                    <i class="fas fa-tractor"></i> Nome
                                </th>
                                <th class="text-center" style="width: 120px;">
                                    <i class="fas fa-tag"></i> Modelo
                                </th>
                                <th class="text-center" style="width: 120px;">
                                    <i class="fas fa-barcode"></i> Nº Série
                                </th>
                                <th class="text-center" style="width: 90px;">
                                    <i class="fas fa-cogs"></i> Tipo
                                </th>
                                <th class="text-center" style="width: 70px;">
                                    <i class="fas fa-calendar"></i> Ano
                                </th>
                                <th class="text-center" style="width: 110px;">
                                    <i class="fas fa-circle"></i> Status
                                </th>
                                <th class="text-center" style="width: 160px;">
                                    <i class="fas fa-cogs"></i> Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($maquinas as $maquina)
                                <tr>
                                    <td class="text-center table-index">#{{ $maquina->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-2">
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
                                            <span class="fw-medium">{{ $maquina->nome }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <code>{{ $maquina->modelo ?? '-' }}</code>
                                    </td>
                                    <td class="text-center">
                                        <code>{{ $maquina->numero_serie }}</code>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">{{ ucfirst($maquina->tipo) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-muted">{{ $maquina->ano }}</span>
                                    </td>
                                    <td class="text-center">
                                        @switch($maquina->status)
                                            @case('livre')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i>Livre
                                                </span>
                                                @break
                                            @case('em_servico')
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-clock me-1"></i>Em Serviço
                                                </span>
                                                @break
                                            @case('manutencao')
                                                <span class="badge bg-info">
                                                    <i class="fas fa-wrench me-1"></i>Manutenção
                                                </span>
                                                @break
                                            @case('inativo')
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-pause me-1"></i>Inativo
                                                </span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-question me-1"></i>{{ ucfirst($maquina->status) }}
                                                </span>
                                        @endswitch
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group-modern" role="group">
                                            <a href="{{ route('maquinas.show', $maquina->id) }}" 
                                               class="btn-action btn-info" 
                                               title="Visualizar">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('maquinas.edit', $maquina->id) }}" 
                                               class="btn-action btn-warning" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('maquinas.destroy', $maquina->id) }}" 
                                                  method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Tem certeza que deseja excluir esta máquina?')">
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
                @if(method_exists($maquinas, 'links'))
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Mostrando {{ $maquinas->firstItem() }} a {{ $maquinas->lastItem() }} 
                            de {{ $maquinas->total() }} resultados
                        </div>
                        <div>
                            {{ $maquinas->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-tractor fa-3x text-muted"></i>
                    </div>
                    <h5 class="text-muted">Nenhuma máquina encontrada</h5>
                    <p class="text-muted mb-4">Não há máquinas cadastradas que correspondam aos filtros aplicados.</p>
                    <a href="{{ route('maquinas.create') }}" class="btn-modern btn-primary">
                        <i class="fas fa-plus me-2"></i>Cadastrar Primeira Máquina
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header igual... -->
    
    {{-- Tabela Reutilizável --}}
    <x-data-table 
        :items="$maquinas"
        :columns="[
            'nome' => [
                'label' => 'Nome',
                'icon' => 'fas fa-tractor',
                'component' => 'components.cells.machine-cell'
            ],
            'modelo' => [
                'label' => 'Modelo',
                'icon' => 'fas fa-tag',
                'class' => 'text-center',
                'cell_class' => 'text-center'
            ],
            'numero_serie' => [
                'label' => 'Nº Série',
                'icon' => 'fas fa-barcode',
                'class' => 'text-center',
                'cell_class' => 'text-center'
            ],
            'tipo' => [
                'label' => 'Tipo',
                'icon' => 'fas fa-cogs',
                'class' => 'text-center',
                'cell_class' => 'text-center'
            ],
            'ano' => [
                'label' => 'Ano',
                'icon' => 'fas fa-calendar',
                'class' => 'text-center',
                'cell_class' => 'text-center'
            ],
            'status' => [
                'label' => 'Status',
                'icon' => 'fas fa-circle',
                'class' => 'text-center',
                'cell_class' => 'text-center',
                'component' => 'components.cells.status-badge'
            ]
        ]"
        title="Lista de Máquinas"
        icon="fas fa-table"
        :total="$maquinas->total()"
        route-prefix="maquinas"
        delete-message="Tem certeza que deseja excluir esta máquina?"
        empty-icon="fas fa-tractor"
        empty-title="Nenhuma máquina encontrada"
        empty-message="Não há máquinas cadastradas que correspondam aos filtros aplicados."
        create-button="Cadastrar Primeira Máquina"
    />
</div>
@endsection
