@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detalhes do Uso de Máquina</h1>

        <div class="card">
            <div class="card-body">
                <p><strong>Data:</strong> {{ $usomaquina->data }}</p>
                <p><strong>Máquina:</strong> {{ $usomaquina->maquina->nome ?? '-' }}</p>
                <p><strong>Operador:</strong> {{ $usomaquina->operador->nome ?? '-' }}</p>
                <p><strong>Início:</strong> {{ $usomaquina->hora_inicio }}</p>
                <p><strong>Fim:</strong> {{ $usomaquina->hora_fim }}</p>
                <p><strong>Total de Horas:</strong> {{ $usomaquina->total_horas }}</p>
                <p><strong>Tarefa:</strong> {{ $usomaquina->tarefa }}</p>
            </div>
        </div>

        <a href="{{ route('usomaquinas.index') }}" class="btn btn-secondary mt-3">Voltar</a>
    </div>
@endsection
