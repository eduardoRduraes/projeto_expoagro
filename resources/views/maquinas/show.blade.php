@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detalhes da Máquina</h1>

        <div class="card">
            <div class="card-body">
                <p class="card-text"><strong>Nome:</strong> {{ $maquina->nome }}</p>
                <p class="card-text"><strong>Modelo:</strong> {{ $maquina->modelo }}</p>
                <p class="card-text"><strong>Número de Série:</strong> {{ $maquina->numero_serie }}</p>
                <p class="card-text"><strong>Tipo:</strong> {{ $maquina->tipo }}</p>
                <p class="card-text"><strong>Ano:</strong> {{ $maquina->ano }}</p>
                <p class="card-text"><strong>Status:</strong> {{ ucfirst($maquina->status) }}</p>
            </div>
        </div>

        <a href="{{ route('maquinas.index') }}" class="btn btn-secondary mt-3">Voltar</a>
    </div>
@endsection

