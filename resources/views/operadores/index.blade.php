@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Lista de Operadores</h1>

        <a href="{{ route('operadores.create') }}" class="btn btn-primary mb-3">Cadastrar Novo Operador</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @forelse($operadores as $operador)
                <tr>
                    <td>{{ $operador->id }}</td>
                    <td>{{ $operador->nome }}</td>
                    <td>{{ $operador->cpf }}</td>
                    <td>{{ $operador->telefone }}</td>
                    <td>
                        <a href="{{ route('operadores.show', $operador->id) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('operadores.edit', $operador->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('operadores.destroy', $operador->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Nenhum operador cadastrado.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
