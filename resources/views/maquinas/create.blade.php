@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h1 class="page-title mb-1">
                    <i class="fas fa-plus me-2"></i>Cadastrar Máquina
                </h1>
                <p class="page-subtitle mb-0">Adicione uma nova máquina ao sistema</p>
            </div>
            <div class="w-100 w-md-auto">
                <a href="{{ route('maquinas.index') }}" class="btn-modern btn-secondary w-100 w-md-auto">
                    <i class="fas fa-arrow-left me-2"></i>Voltar à Lista
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-tractor me-2"></i>Informações da Máquina
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('maquinas.store') }}" method="POST">
                @csrf
                @include('maquinas.form')

                <div class="d-flex flex-column flex-sm-row gap-2 mt-4 pt-3 border-top">
                    <button type="submit" class="btn-modern btn-success flex-fill">
                        <i class="fas fa-save me-2"></i>Salvar Máquina
                    </button>
                    <a href="{{ route('maquinas.index') }}" class="btn-modern btn-secondary flex-fill">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

