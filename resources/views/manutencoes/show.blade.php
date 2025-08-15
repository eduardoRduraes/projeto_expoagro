@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detalhes da Manutenção</h1>

        <div class="card">
            <div class="card-body">
                <p class="card-text"><strong>Máquina:</strong> {{ $manutencao->maquina->nome }}</p>
                <p class="card-text"><strong>Descrição:</strong> {{ $manutencao->descricao }}</p>
                <p class="card-text"><strong>Tipo:</strong> {{ ucfirst($manutencao->tipo) }}</p>
                <p class="card-text"><strong>Custo:</strong> R$ {{ number_format($manutencao->custo, 2, ',', '.') }}</p>
                <p class="card-text"><strong>Data da Manutenção:</strong> {{ $manutencao->data_manutencao ? $manutencao->data_manutencao->format('d/m/Y') : 'Não informada' }}</p>
                <p class="card-text"><strong>Responsável:</strong> {{ $manutencao->responsavel ?? 'Não informado' }}</p>
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

        <a href="{{ route('manutencoes.index') }}" class="btn-modern btn-secondary mt-3">Voltar</a>
    </div>
@endsection

