@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detalhes da Manutenção</h1>

        <div class="card">
            <div class="card-body">
                <p class="card-text"><strong>Descricao:</strong> {{ $manutencao->maquina->nome }}</p>
                <p class="card-text"><strong>Modelo:</strong> {{ $manutencao->descricao }}</p>
                <p class="card-text"><strong>Número de Série:</strong> {{ $manutencao->tipo }}</p>
                <p class="card-text"><strong>Tipo:</strong> {{ $manutencao->custo }}</p>
                <p class="card-text"><strong>Ano:</strong> {{ $manutencao->ano }}</p>
                <strong>Status:</strong>
                @switch($manutencao->status)
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

        <a href="{{ route('maquinas.index') }}" class="btn btn-secondary mt-3">Voltar</a>
    </div>
@endsection

