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
                <strong>Status:</strong>
                @switch($maquina->status)
                    @case('livre')
                        <span class="badge bg-success">Livre</span>
                        @break

                    @case('em_servico')
                        <span class="badge bg-warning text-dark">Em Serviço</span>
                        @break

                    @case('inativo')
                        <span class="badge bg-secondary">Inativo</span>
                        @break

                    @case('manutencoes')
                        <span class="badge bg-info text-dark">Manutenção</span>
                        @break
                @endswitch
            </div>
        </div>

        <a href="{{ route('maquinas.index') }}" class="btn-modern btn-secondary mt-3">Voltar</a>
    </div>
@endsection

