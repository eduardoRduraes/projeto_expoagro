@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Cadastrar Operadores</h1>

        <form action="{{ route('operadores.store') }}" method="POST">
            @csrf
            @include('operadores.form')

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('operadores.index') }}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
@endsection

