@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Lista de Máquinas</h1>

        <a href="{{ route('maquinas.create') }}" class="btn btn-primary mb-3">Cadastrar Nova Máquina</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Modelo</th>
                <th>Nº Série</th>
                <th>Tipo</th>
                <th>Ano</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($maquinas as $maquina)
                <tr>
                    <td>{{ $maquina->id }}</td>
                    <td>{{ $maquina->nome }}</td>
                    <td>{{ $maquina->modelo }}</td>
                    <td>{{ $maquina->numero_serie }}</td>
                    <td>{{ $maquina->tipo }}</td>
                    <td>{{ $maquina->ano }}</td>
                    <td>{{ ucfirst($maquina->status) }}</td>
                    <td>
                        <a href="{{ route('maquinas.show', $maquina->id) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('maquinas.edit', $maquina->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('maquinas.destroy', $maquina->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?')">
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

