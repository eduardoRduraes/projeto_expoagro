@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Título e botão fixos --}}

        <div class="sticky-top bg-white py-3" style="z-index: 1020;">
            <h1 class="mb-2">Maquinas em Manutenção</h1>
            <a href="{{ route('manutencoes.create') }}" class="btn btn-primary mb-2">Inserir Manutenção</a>
            @if(session('success'))
                <div class="alert alert-success mt-2 mb-0">{{ session('success') }}</div>
            @endif

        </div>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th style="background: white;">ID</th>
                <th style="background: white;">Maquina</th>
                <th style="background: white;">Descrição</th>
                <th style="background: white;">Tipo</th>
                <th style="background: white;">Custo</th>
                <th style="background: white;">Status</th>
                <th style="background: white;">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($manutencoes as $manutencao)
                <tr>
                    <td>{{ $manutencao->id }}</td>
                    <td>{{ $manutencao->nome }}</td>
                    <td>{{ $manutencao->descricao }}</td>
                    <td>{{ ucfirst($manutencao->tipo) }}</td>
                    <td>
                        @switch($manutencao->maquina->status)
                            @case('livre')
                                <span class="badge bg-success" style="min-width: 100px;">LIVRE</span>
                                @break
                            @case('inativo')
                                <span class="badge bg-secondary" style="min-width: 100px;">INATIVO</span>
                                @break
                            @case('manutencoes')
                                <span class="badge bg-info text-dark" style="min-width: 100px;">MANUTENÇÃO</span>
                                @break
                        @endswitch
                    </td>
                    <td>
                        <a href="{{ route('manutencao.show', $manutencao->id) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('manutencao.edit', $manutencao->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('manutencao.destroy', $manutencao->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
