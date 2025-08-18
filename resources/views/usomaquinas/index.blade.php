@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h1 class="page-title mb-1">
                    <i class="fas fa-clock me-2"></i>Uso de Máquinas
                </h1>
                <p class="page-subtitle mb-0">Gerencie os registros de uso das máquinas</p>
            </div>
            <div class="w-100 w-md-auto">
                <a href="{{ route('usomaquinas.create') }}" class="btn-modern btn-primary w-100 w-md-auto">
                    <i class="fas fa-plus me-2"></i>Novo Registro
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
            <form method="GET" action="{{ route('usomaquinas.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="maquina_id" class="form-label">Máquina</label>
                        <select class="form-select" id="maquina_id" name="maquina_id">
                            <option value="">Todas as Máquinas</option>
                            @if(isset($maquinas))
                                @foreach($maquinas as $maquina)
                                    <option value="{{ $maquina->id }}" {{ request('maquina_id') == $maquina->id ? 'selected' : '' }}>
                                        {{ $maquina->nome }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="operador_id" class="form-label">Operador</label>
                        <select class="form-select" id="operador_id" name="operador_id">
                            <option value="">Todos os Operadores</option>
                            @if(isset($operadores))
                                @foreach($operadores as $operador)
                                    <option value="{{ $operador->id }}" {{ request('operador_id') == $operador->id ? 'selected' : '' }}>
                                        {{ $operador->nome }}
                                    </option>
                                @endforeach
                            @endif
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
                        <div class="d-flex gap-2 w-100">
                            <button type="submit" class="btn-modern btn-primary flex-fill">
                                <i class="fas fa-search me-2"></i>Filtrar
                            </button>
                            <a href="{{ route('usomaquinas.index') }}" class="btn-modern btn-secondary flex-fill">
                                <i class="fas fa-times me-2"></i>Limpar
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
                Registros de Uso
                <span class="badge bg-primary ms-2">{{ $usos->total() }}</span>
            </h6>
        </div>
        <div class="card-body">
            @if($usos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 80px;">
                                    <i class="fas fa-hashtag"></i> ID
                                </th>
                                <th class="text-center" style="width: 120px;">
                                    <i class="fas fa-calendar"></i> Data
                                </th>
                                <th>
                                    <i class="fas fa-tractor"></i> Máquina
                                </th>
                                <th>
                                    <i class="fas fa-user"></i> Operador
                                </th>
                                <th class="text-center" style="width: 100px;">
                                    <i class="fas fa-play"></i> Início
                                </th>
                                <th class="text-center" style="width: 100px;">
                                    <i class="fas fa-stop"></i> Fim
                                </th>
                                <th class="text-center" style="width: 100px;">
                                    <i class="fas fa-clock"></i> Total (h)
                                </th>
                                <th class="text-center" style="width: 180px;">
                                    <i class="fas fa-cogs"></i> Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usos as $uso)
                                <tr>
                                    <td class="text-center fw-bold">#{{ $uso->id }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">
                                            {{ \Carbon\Carbon::parse($uso->data)->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-tractor text-muted"></i>
                                            </div>
                                            <div>
                                                <span class="fw-medium">{{ $uso->maquina->nome ?? '-' }}</span>
                                                @if($uso->maquina && $uso->maquina->modelo)
                                                    <br><small class="text-muted">{{ $uso->maquina->modelo }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-user text-muted"></i>
                                            </div>
                                            <span class="fw-medium">{{ $uso->operador->nome ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success">
                                            <i class="fas fa-play me-1"></i>{{ $uso->hora_inicio }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger">
                                            <i class="fas fa-stop me-1"></i>{{ $uso->hora_fim }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">
                                            <i class="fas fa-clock me-1"></i>{{ $uso->total_horas }}h
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group-modern" role="group">
                            <a href="{{ route('usomaquinas.show', $uso->id) }}" 
                               class="btn-action btn-info" 
                               title="Visualizar">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('usomaquinas.edit', $uso->id) }}" 
                               class="btn-action btn-warning" 
                               title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('usomaquinas.destroy', $uso->id) }}" 
                                  method="POST" class="d-inline" 
                                  onsubmit="return confirm('Tem certeza que deseja excluir este registro de uso?')">
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
                @if(method_exists($usos, 'links'))
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Mostrando {{ $usos->firstItem() }} a {{ $usos->lastItem() }} 
                            de {{ $usos->total() }} resultados
                        </div>
                        <div>
                            {{ $usos->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-clock fa-3x text-muted"></i>
                    </div>
                    <h5 class="text-muted">Nenhum registro encontrado</h5>
                    <p class="text-muted mb-4">Não há registros de uso que correspondam aos filtros aplicados.</p>
                    <a href="{{ route('usomaquinas.create') }}" class="btn-modern btn-primary">
                        <i class="fas fa-plus me-2"></i>Criar Primeiro Registro
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
