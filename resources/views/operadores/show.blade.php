@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detalhes do Operador</h1>

        <div class="card">
            <div class="card-body">
                <p class="card-text"><strong>Nome:</strong> {{ $operador->nome }}</p>
                <p class="card-text"><strong>CPF:</strong> {{ $operador->cpf }}</p>
                <p class="card-text"><strong>Telefone:</strong> {{ $operador->telefone }}</p>
                <p class="card-text"><strong>CNH:</strong> {{ $operador->cnh }}</p>
            </div>
        </div>

        <a href="{{ route('operadores.index') }}" class="btn btn-secondary mt-3">Voltar</a>
    </div>
@endsection
