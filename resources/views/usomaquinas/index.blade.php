@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Registros de Uso de Máquinas</h1>

        <a href="{{ route('usomaquinas.create') }}" class="btn btn-primary mb-3">Novo Registro</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Data</th>
                <th>Máquina</th>
                <th>Operador</th>
                <th>Início</th>
                <th>Fim</th>
                <th>Total (h)</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($usos as $uso)
                <tr>
                    <td>{{ $uso->data }}</td>
                    <td>{{ $uso->maquina->nome ?? '-' }}</td>
                    <td>{{ $uso->operador->nome ?? '-' }}</td>
                    <td>{{ $uso->hora_inicio }}</td>
                    <td>{{ $uso->hora_fim }}</td>
                    <td>{{ $uso->total_horas }}</td>
                    <td>
                        <a href="{{ route('usomaquinas.show', $uso->id) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('usomaquinas.edit', $uso->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('usomaquinas.destroy', $uso->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja excluir este uso?')">
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
