@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Editar Uso de Máquina</h1>

        <form action="{{ route('usomaquinas.update', $usomaquina->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('usomaquinas.form')

            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('usomaquinas.index') }}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
@endsection
