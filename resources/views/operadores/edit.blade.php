@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Editar Máquina</h1>

        <form action="{{ route('operadores.update', $operador->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('operadores.form')

            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('operadores.index') }}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
@endsection

