@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Editar Máquina</h1>

        <form action="{{ route('maquinas.update', $maquina->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('maquinas.form')

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn-modern btn-primary">
                    <i class="fas fa-sync-alt me-2"></i>Atualizar
                </button>
                <a href="{{ route('maquinas.index') }}" class="btn-modern btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Voltar
                </a>
            </div>
        </form>
    </div>
@endsection

