@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detalhes do Operador</h1>

        <div class="card">
            <div class="card-body">
                <p class="card-text"> <strong>Nome:</strong> {{ $operador->nome }}</p>
                <p class="card-text">
                    <strong>CPF:</strong>
                    {{ preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "$1.$2.$3-$4", preg_replace("/\D/", "", $operador->cpf)) }}
                </p>
                <p>
                    <strong>Telefone:</strong>
                    {{ preg_replace("/(\d{2})(\d{5})(\d{4})/", "($1) $2-$3", preg_replace("/\D/", "", $operador->telefone)) ?? 'Não informado' }}
                </p>
                <p>
                <strong>Status:</strong>
                    @switch($operador->status)
                        @case('livre')
                            <span class="badge bg-success">Livre</span>
                            @break
                        @case('em_servico')
                            <span class="badge bg-warning text-dark">Em Serviço</span>
                            @break
                    @endswitch
                </p>
                <p>
                <strong>Categoria CNH:</strong> {{ $operador->categoria_cnh }}
                </p>
            </div>
        </div>

        <a href="{{ route('operadores.index') }}" class="btn-modern btn-secondary mt-3">Voltar</a>
    </div>
@endsection
