@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Cadastrar Operadores</h1>

        <form action="{{ route('operadores.store') }}" method="POST">
            @csrf
            @include('operadores.form')

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn-modern btn-success">
                    <i class="fas fa-save me-2"></i>Salvar
                </button>
                <a href="{{ route('operadores.index') }}" class="btn-modern btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Voltar
                </a>
            </div>
        </form>
    </div>
@endsection

