@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h1 class="page-title mb-1">
                    <i class="fas fa-users me-2"></i>Operadores
                </h1>
                <p class="page-subtitle mb-0">Gerencie os operadores do sistema</p>
            </div>
            <div class="w-100 w-md-auto">
                <a href="{{ route('operadores.create') }}" class="btn-modern btn-primary w-100 w-md-auto">
                    <i class="fas fa-plus me-2"></i>Novo Operador
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
            <form method="GET" action="{{ route('operadores.index') }}">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="search" class="form-label">Buscar por Nome ou CPF</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Digite o nome ou CPF...">
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Todos os Status</option>
                            <option value="livre" {{ request('status') == 'livre' ? 'selected' : '' }}>Livre</option>
                            <option value="em_servico" {{ request('status') == 'em_servico' ? 'selected' : '' }}>Em Serviço</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="categoria_cnh" class="form-label">Categoria CNH</label>
                        <select class="form-select" id="categoria_cnh" name="categoria_cnh">
                            <option value="">Todas as Categorias</option>
                            <option value="A" {{ request('categoria_cnh') == 'A' ? 'selected' : '' }}>A - Motocicletas</option>
                            <option value="B" {{ request('categoria_cnh') == 'B' ? 'selected' : '' }}>B - Automóveis</option>
                            <option value="C" {{ request('categoria_cnh') == 'C' ? 'selected' : '' }}>C - Veículos de Carga</option>
                            <option value="D" {{ request('categoria_cnh') == 'D' ? 'selected' : '' }}>D - Transporte de Passageiros</option>
                            <option value="E" {{ request('categoria_cnh') == 'E' ? 'selected' : '' }}>E - Veículos Articulados</option>
                            <option value="AB" {{ request('categoria_cnh') == 'AB' ? 'selected' : '' }}>AB - Moto + Carro</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <div class="btn-group w-100" role="group">
                            <button type="submit" class="btn-modern btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('operadores.index') }}" class="btn-modern btn-secondary">
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
                Lista de Operadores
                <span class="badge bg-primary ms-2">{{ $operadores->total() }}</span>
            </h6>
        </div>
        <div class="card-body">
            @if($operadores->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center col-id">
                                    <i class="fas fa-hashtag"></i> ID
                                </th>
                                <th>
                                    <i class="fas fa-user"></i> Nome
                                </th>
                                <th class="text-center" style="width: 140px;">
                                    <i class="fas fa-id-card"></i> CPF
                                </th>
                                <th class="text-center" style="width: 140px;">
                                    <i class="fas fa-phone"></i> Telefone
                                </th>
                                <th class="text-center" style="width: 100px;">
                                    <i class="fas fa-car"></i> CNH
                                </th>
                                <th class="text-center" style="width: 120px;">
                                    <i class="fas fa-circle"></i> Status
                                </th>
                                <th class="text-center" style="width: 180px;">
                                    <i class="fas fa-cogs"></i> Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($operadores as $operador)
                                <tr>
                                    <td class="text-center table-index">#{{ $operador->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-user text-muted"></i>
                                            </div>
                                            <span class="fw-medium">{{ $operador->nome }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <code>{{ preg_replace("/([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})/", "$1.$2.$3-$4", preg_replace("/\D/", "", $operador->cpf)) }}</code>
                                    </td>
                                    <td class="text-center">
                                        @if($operador->telefone)
                                            <span class="text-muted">
                                                {{ preg_replace("/([0-9]{2})([0-9]{5})([0-9]{4})/", "($1) $2-$3", preg_replace("/\D/", "", $operador->telefone)) }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">{{ $operador->categoria_cnh ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-center">
                                        @switch($operador->status)
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
                                            @default
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-question me-1"></i>{{ ucfirst($operador->status) }}
                                                </span>
                                        @endswitch
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group-modern" role="group">
                                            <a href="{{ route('operadores.show', $operador->id) }}" 
                                               class="btn-action btn-info" 
                                               title="Visualizar">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('operadores.edit', $operador->id) }}" 
                                               class="btn-action btn-warning" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('operadores.destroy', $operador->id) }}" 
                                                  method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Tem certeza que deseja excluir este operador?')">
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
                @if(method_exists($operadores, 'links'))
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Mostrando {{ $operadores->firstItem() }} a {{ $operadores->lastItem() }} 
                            de {{ $operadores->total() }} resultados
                        </div>
                        <div>
                            {{ $operadores->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-users fa-3x text-muted"></i>
                    </div>
                    <h5 class="text-muted">Nenhum operador encontrado</h5>
                    <p class="text-muted mb-4">Não há operadores cadastrados que correspondam aos filtros aplicados.</p>
                    <a href="{{ route('operadores.create') }}" class="btn-modern btn-primary">
                        <i class="fas fa-plus me-2"></i>Cadastrar Primeiro Operador
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
