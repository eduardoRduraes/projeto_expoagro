@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Registrar Uso de Máquina</h1>

        <form action="{{ route('usomaquinas.store') }}" method="POST">
            @csrf
            @include('usomaquinas.form')

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('usomaquinas.index') }}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
@endsection
