@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h1 class="page-title mb-1">
                    <i class="fas fa-plus me-2"></i>Cadastrar Operador
                </h1>
                <p class="page-subtitle mb-0">Adicione um novo operador ao sistema</p>
            </div>
            <div class="w-100 w-md-auto">
                <a href="{{ route('operadores.index') }}" class="btn-modern btn-secondary w-100 w-md-auto">
                    <i class="fas fa-arrow-left me-2"></i>Voltar à Lista
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-user me-2"></i>Informações do Operador
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('operadores.store') }}" method="POST">
                @csrf
                @include('operadores.form')

                <div class="d-flex flex-column flex-sm-row gap-2 mt-4 pt-3 border-top">
                    <button type="submit" class="btn-modern btn-success flex-fill">
                        <i class="fas fa-save me-2"></i>Salvar Operador
                    </button>
                    <a href="{{ route('operadores.index') }}" class="btn-modern btn-secondary flex-fill">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

